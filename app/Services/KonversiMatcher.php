<?php

namespace App\Services;

use App\Models\MataKuliah;

/**
 * Pencocokan mata kuliah untuk fitur Konversi (RPL).
 * Algoritma di-port dari proyek unsia-story (rpl-konversi.php & api_mk_search.php).
 */
class KonversiMatcher
{
    public const TARGET_SKS = 144;

    /**
     * Nama persis sama (setelah normalisasi spasi/strip/slash).
     */
    public function exactMatch(string $input, string $namaMk): int
    {
        $a = mb_strtolower(trim($input));
        $b = mb_strtolower(trim($namaMk));

        if ($a === $b) {
            return 100;
        }

        $a = preg_replace('/[\s\-\/]+/', ' ', $a);
        $b = preg_replace('/[\s\-\/]+/', ' ', $b);

        return $a === $b ? 100 : 0;
    }

    /**
     * Skor kemiripan nama mata kuliah (0-100).
     */
    public function similarMatch(string $input, string $namaMk, ?string $keywords): int
    {
        $input = mb_strtolower(trim($input));
        $mkLower = mb_strtolower(trim($namaMk));

        if ($this->exactMatch($input, $namaMk) === 100) {
            return 0;
        }

        if (str_contains($mkLower, $input)) {
            return 90;
        }

        if (str_contains($input, $mkLower)) {
            return 88;
        }

        $inputWords = $this->words($input);
        $mkWords = $this->words($mkLower);
        $kwWords = $this->keywordList($keywords);

        if ($inputWords === [] || $mkWords === []) {
            return 0;
        }

        $matchedInMk = 0;
        $matchedInInput = 0;
        $targets = array_merge($mkWords, $kwWords);

        foreach ($inputWords as $iw) {
            foreach ($targets as $tw) {
                if ($iw === $tw || str_contains($tw, $iw) || str_contains($iw, $tw)) {
                    $matchedInMk++;
                    break;
                }
                similar_text($iw, $tw, $p);
                if ($p >= 85) {
                    $matchedInMk++;
                    break;
                }
            }
        }

        foreach ($mkWords as $mw) {
            foreach ($inputWords as $iw) {
                if ($mw === $iw || str_contains($iw, $mw) || str_contains($mw, $iw)) {
                    $matchedInInput++;
                    break;
                }
                similar_text($mw, $iw, $p);
                if ($p >= 85) {
                    $matchedInInput++;
                    break;
                }
            }
        }

        $scoreFromInput = ($matchedInMk / count($inputWords)) * 100;
        $scoreFromMk = ($matchedInInput / count($mkWords)) * 100;

        return (int) round(($scoreFromInput + $scoreFromMk) / 2);
    }

    /**
     * Ranking prodi berdasarkan mata kuliah yang diinput.
     *
     * @param  array<int, string>  $inputMk
     * @return array<int, array<string, mixed>>
     */
    public function analyze(array $inputMk): array
    {
        $prodis = MataKuliah::query()->distinct()->orderBy('prodi')->pluck('prodi');
        $results = [];

        foreach ($prodis as $prodi) {
            $mkProdi = MataKuliah::query()
                ->where('prodi', $prodi)
                ->berbobot()
                ->get(['id', 'nama_mk', 'sks', 'semester', 'keywords', 'peminatan']);

            $exactMatched = [];
            $similarMatched = [];
            $unmatched = [];
            $sksExact = 0;
            $sksSimilar = 0;
            $totalSks = 0;

            foreach ($mkProdi as $mk) {
                $totalSks += $mk->sks;
                $bestType = 'none';
                $bestScore = 0;
                $matchedWith = '';

                foreach ($inputMk as $input) {
                    if ($this->exactMatch($input, $mk->nama_mk) === 100) {
                        $bestType = 'exact';
                        $bestScore = 100;
                        $matchedWith = $input;
                        break;
                    }

                    $scoreSimilar = $this->similarMatch($input, $mk->nama_mk, $mk->keywords);
                    if ($scoreSimilar >= 75 && $scoreSimilar > $bestScore) {
                        $bestType = 'similar';
                        $bestScore = $scoreSimilar;
                        $matchedWith = $input;
                    }
                }

                $row = [
                    'mk' => $mk->nama_mk,
                    'sks' => $mk->sks,
                    'semester' => $mk->semester,
                    'score' => $bestScore,
                    'matched_with' => $matchedWith,
                ];

                if ($bestType === 'exact') {
                    $exactMatched[] = $row;
                    $sksExact += $mk->sks;
                } elseif ($bestType === 'similar') {
                    $similarMatched[] = $row;
                    $sksSimilar += $mk->sks;
                } else {
                    $unmatched[] = ['mk' => $mk->nama_mk, 'sks' => $mk->sks, 'semester' => $mk->semester];
                }
            }

            $sksTotalMatched = $sksExact + $sksSimilar;
            $sksRemaining = max(self::TARGET_SKS - $sksTotalMatched, 0);
            $percentage = $totalSks > 0 ? round(($sksTotalMatched / self::TARGET_SKS) * 100, 1) : 0;

            $results[] = [
                'prodi' => $prodi,
                'percentage' => $percentage,
                'exact_matched' => $exactMatched,
                'similar_matched' => $similarMatched,
                'unmatched' => $unmatched,
                'sks_exact' => $sksExact,
                'sks_similar' => $sksSimilar,
                'sks_total_matched' => $sksTotalMatched,
                'sks_remaining' => $sksRemaining,
                'total_mk' => $mkProdi->count(),
            ];
        }

        usort($results, function ($a, $b) {
            if ($b['sks_exact'] !== $a['sks_exact']) {
                return $b['sks_exact'] <=> $a['sks_exact'];
            }
            if ($b['percentage'] !== $a['percentage']) {
                return $b['percentage'] <=> $a['percentage'];
            }

            return $b['sks_total_matched'] <=> $a['sks_total_matched'];
        });

        return $results;
    }

    /**
     * Cari padanan terdekat untuk mata kuliah yang diketik manual.
     *
     * @param  array<int, string>  $freetextMk
     * @return array<int, array<string, mixed>>
     */
    public function analyzeFreetext(array $freetextMk): array
    {
        if ($freetextMk === []) {
            return [];
        }

        $allMk = MataKuliah::query()->berbobot()->get(['nama_mk', 'keywords'])->unique('nama_mk');
        $analysis = [];

        foreach ($freetextMk as $ft) {
            $bestMatch = null;
            $bestScore = 0;

            foreach ($allMk as $mk) {
                $score = max(
                    $this->similarMatch($ft, $mk->nama_mk, $mk->keywords),
                    $this->exactMatch($ft, $mk->nama_mk)
                );

                if ($score > $bestScore) {
                    $bestScore = $score;
                    $bestMatch = $mk->nama_mk;
                }
            }

            $hasMatch = $bestScore >= 50;

            $analysis[] = [
                'input' => $ft,
                'match' => $hasMatch ? $bestMatch : null,
                'score' => $hasMatch ? $bestScore : 0,
                'status' => $bestScore >= 75 ? 'cocok' : ($bestScore >= 50 ? 'mungkin_cocok' : 'tidak_cocok'),
            ];
        }

        return $analysis;
    }

    /**
     * Smart match untuk autocomplete (dipakai endpoint pencarian).
     *
     * @return array<int, array<string, mixed>>
     */
    public function fuzzySearch(string $query, int $limit = 15): array
    {
        $input = mb_strtolower(trim($query));
        $inputWords = $this->words($input);

        if ($inputWords === []) {
            return [];
        }

        $allMk = MataKuliah::query()
            ->berbobot()
            ->get(['nama_mk', 'prodi', 'sks', 'keywords']);

        $results = [];
        $seen = [];

        foreach ($allMk as $mk) {
            if (isset($seen[$mk->nama_mk])) {
                continue;
            }

            $mkLower = mb_strtolower($mk->nama_mk);
            $mkWords = $this->words($mkLower);
            $targets = array_merge($mkWords, $this->keywordList($mk->keywords));

            if ($input === $mkLower) {
                $score = 100;
            } elseif (str_contains($mkLower, $input)) {
                $score = 90;
            } elseif (str_contains($input, $mkLower)) {
                $score = 85;
            } else {
                $matchedInput = 0;
                $matchedMk = 0;

                foreach ($inputWords as $iw) {
                    $best = 0;
                    foreach ($targets as $tw) {
                        if ($iw === $tw) {
                            $best = 100;
                            break;
                        }
                        if (str_contains($tw, $iw) || str_contains($iw, $tw)) {
                            $best = max($best, 80);
                        }
                        similar_text($iw, $tw, $p);
                        $best = max($best, $p);
                    }
                    if ($best >= 75) {
                        $matchedInput++;
                    }
                }

                foreach ($mkWords as $mw) {
                    $best = 0;
                    foreach ($inputWords as $iw) {
                        if ($mw === $iw) {
                            $best = 100;
                            break;
                        }
                        if (str_contains($iw, $mw) || str_contains($mw, $iw)) {
                            $best = max($best, 80);
                        }
                        similar_text($mw, $iw, $p);
                        $best = max($best, $p);
                    }
                    if ($best >= 75) {
                        $matchedMk++;
                    }
                }

                $scoreInput = ($matchedInput / count($inputWords)) * 100;
                $scoreMk = count($mkWords) > 0 ? ($matchedMk / count($mkWords)) * 100 : 0;
                $score = (int) round(($scoreInput + $scoreMk) / 2);
            }

            if ($score >= 40) {
                $seen[$mk->nama_mk] = true;
                $results[] = [
                    'nama' => $mk->nama_mk,
                    'prodi' => $mk->prodi,
                    'sks' => $mk->sks,
                    'score' => $score,
                    'keywords' => $mk->keywords,
                ];
            }
        }

        usort($results, fn ($a, $b) => $b['score'] <=> $a['score']);

        return array_slice($results, 0, $limit);
    }

    /**
     * @return array<int, string>
     */
    private function words(string $text): array
    {
        return array_values(array_filter(
            preg_split('/[\s,\-\/&]+/', $text) ?: [],
            fn ($w) => mb_strlen($w) >= 3
        ));
    }

    /**
     * @return array<int, string>
     */
    private function keywordList(?string $keywords): array
    {
        if (! $keywords) {
            return [];
        }

        return array_values(array_filter(
            array_map('trim', explode(',', mb_strtolower($keywords))),
            fn ($w) => mb_strlen($w) >= 3
        ));
    }
}
