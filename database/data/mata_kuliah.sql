-- Data mata kuliah UNSIA (di-port dari proyek unsia-story: db_import.sql)
-- Dipakai oleh database/seeders/MataKuliahSeeder.php


-- =============================================
-- SISTEM INFORMASI (144 SKS, 8 Semester)
-- =============================================

-- Semester 1 (18 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Sistem Informasi', '200.002.104', 'Bahasa Inggris', 2, 1, 'MKU', '', 'bahasa,inggris,english'),
('Sistem Informasi', '200.002.108', 'ICT Literacy', 2, 1, 'MKU', '', 'ict,literacy,komputer,dasar,teknologi'),
('Sistem Informasi', '200.201.201', 'Manajemen Umum', 2, 1, 'MKWP', '', 'manajemen,umum,pengantar,management'),
('Sistem Informasi', '200.201.202', 'Dasar-Dasar Pemrograman', 3, 1, 'MKWP', '', 'dasar,pemrograman,programming,algoritma'),
('Sistem Informasi', '200.201.203', 'Struktur Data dan Algoritma', 3, 1, 'MKWP', '', 'struktur,data,algoritma,array,linked list'),
('Sistem Informasi', '200.201.204', 'Pengantar Teknologi Sistem Informasi', 2, 1, 'MKWP', '', 'pengantar,teknologi,sistem,informasi'),
('Sistem Informasi', '200.201.205', 'Pengantar Sistem Informasi Bisnis', 2, 1, 'MKWP', '', 'pengantar,sistem,informasi,bisnis'),
('Sistem Informasi', '200.201.206', 'Manajemen Teknologi Sistem Informasi', 2, 1, 'MKWP', '', 'manajemen,teknologi,sistem,informasi');

-- Semester 2 (18 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Sistem Informasi', '200.001.101', 'Pancasila', 2, 2, 'MKU', '', 'pancasila,pendidikan'),
('Sistem Informasi', '200.002.106', 'Estetika Humanisme', 2, 2, 'MKU', '', 'estetika,humanisme,humaniora'),
('Sistem Informasi', '200.202.207', 'Matematika Diskrit', 2, 2, 'MKWP', '', 'matematika,diskrit,logika,himpunan'),
('Sistem Informasi', '200.202.208', 'Aljabar Linear', 2, 2, 'MKWP', '', 'aljabar,linear,linier,matriks,vektor'),
('Sistem Informasi', '200.202.209', 'Organisasi dan Arsitektur Komputer', 2, 2, 'MKWP', '', 'organisasi,arsitektur,komputer,hardware'),
('Sistem Informasi', '200.202.210', 'Teori Perilaku Organisasi', 2, 2, 'MKWP', '', 'teori,perilaku,organisasi,behavior'),
('Sistem Informasi', '200.202.211', 'Analisis Proses Bisnis', 3, 2, 'MKWP', '', 'analisis,proses,bisnis,business,process'),
('Sistem Informasi', '200.202.212', 'Sistem Operasi', 3, 2, 'MKWP', '', 'sistem,operasi,operating,system,linux,windows');

-- Semester 3 (21 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Sistem Informasi', '200.001.102', 'Pendidikan Kewarganegaraan', 2, 3, 'MKU', '', 'pendidikan,kewarganegaraan,pkn'),
('Sistem Informasi', '200.001.107', 'Agama', 2, 3, 'MKU', '', 'agama,pendidikan,agama'),
('Sistem Informasi', '', 'Bahasa Korea', 2, 3, 'MKU', '', 'bahasa,korea,korean'),
('Sistem Informasi', '200.201.213', 'Statistika dan Probabilitas', 3, 3, 'MKWP', '', 'statistika,probabilitas,statistik,data'),
('Sistem Informasi', '200.201.300', 'Pemrograman Lanjut', 3, 3, 'MKWP', '', 'pemrograman,lanjut,advanced,programming'),
('Sistem Informasi', '200.201.301', 'Sistem Basis Data', 3, 3, 'MKWP', '', 'sistem,basis,data,database,sql,mysql'),
('Sistem Informasi', '200.201.302', 'Komunikasi Data dan Jaringan Komputer', 3, 3, 'MKWP', '', 'komunikasi,data,jaringan,komputer,network'),
('Sistem Informasi', '200.201.303', 'Interaksi Manusia dan Komputer', 3, 3, 'MKWP', '', 'interaksi,manusia,komputer,imk,hci,user,interface');

-- Semester 4 (20 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Sistem Informasi', '200.002.103', 'Bahasa Indonesia', 2, 4, 'MKU', '', 'bahasa,indonesia'),
('Sistem Informasi', '200.202.304', 'Business Intelligence', 3, 4, 'MKWP', '', 'business,intelligence,bi,data,analitik'),
('Sistem Informasi', '200.202.305', 'Keamanan Sistem Informasi', 3, 4, 'MKWP', '', 'keamanan,sistem,informasi,security'),
('Sistem Informasi', '200.202.306', 'E-Business', 3, 4, 'MKWP', '', 'e-business,ebusiness,bisnis,digital,online'),
('Sistem Informasi', '200.202.307', 'Pemrograman Visual', 3, 4, 'MKWP', '', 'pemrograman,visual,gui,desktop,vb'),
('Sistem Informasi', '200.202.214', 'Sistem Informasi Akuntansi', 3, 4, 'MKWP', '', 'sistem,informasi,akuntansi,sia,accounting'),
('Sistem Informasi', '200.202.308', 'Pemrograman Berorientasi Objek', 3, 4, 'MKWP', '', 'pemrograman,berorientasi,objek,oop,java,class');

-- Semester 5 (18 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Sistem Informasi', '200.201.309', 'Pemrograman Berbasis Web', 3, 5, 'MKWP', '', 'pemrograman,web,html,css,javascript,php'),
('Sistem Informasi', '200.201.310', 'Analisis dan Perancangan Sistem Informasi', 3, 5, 'MKWP', '', 'analisis,perancangan,sistem,informasi,design'),
('Sistem Informasi', '200.201.311', 'Data Mining', 3, 5, 'MKWP', '', 'data,mining,penambangan,data,pattern'),
('Sistem Informasi', '200.201.312', 'Analisis dan Visualisasi Data', 3, 5, 'MKWP', '', 'analisis,visualisasi,data,dashboard,chart'),
('Sistem Informasi', '200.201.313', 'Kecerdasan Buatan', 3, 5, 'MKWP', '', 'kecerdasan,buatan,artificial,intelligence,ai'),
('Sistem Informasi', '', 'Mata Kuliah Pilihan 1', 3, 5, 'MKP', '', 'pilihan'),
('Sistem Informasi', '200.201.400', 'E-Commerce', 0, 5, 'MKP', 'Pilihan', 'e-commerce,ecommerce,toko,online,marketplace'),
('Sistem Informasi', '200.201.401', 'Sistem Pendukung Keputusan', 0, 5, 'MKP', 'Pilihan', 'sistem,pendukung,keputusan,spk,decision,support');

-- Semester 6 (18 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Sistem Informasi', '200.202.314', 'Rekayasa Perangkat Lunak', 3, 6, 'MKWP', '', 'rekayasa,perangkat,lunak,software,engineering'),
('Sistem Informasi', '200.202.315', 'Kerja Praktik', 2, 6, 'MKWP', '', 'kerja,praktik,magang,internship'),
('Sistem Informasi', '200.002.105', 'Kewirausahaan', 2, 6, 'MKU', '', 'kewirausahaan,wirausaha,entrepreneurship'),
('Sistem Informasi', '200.202.316', 'Metodologi Riset dan Penulisan Ilmiah SI', 2, 6, 'MKWP', '', 'metodologi,riset,penulisan,ilmiah,penelitian'),
('Sistem Informasi', '200.202.317', 'Enterprise Resource Planning', 3, 6, 'MKWP', '', 'enterprise,resource,planning,erp,sap'),
('Sistem Informasi', '200.202.318', 'Arsitektur Sistem Enterprise', 3, 6, 'MKWP', '', 'arsitektur,sistem,enterprise,soa'),
('Sistem Informasi', '', 'Mata Kuliah Pilihan 2', 3, 6, 'MKP', '', 'pilihan'),
('Sistem Informasi', '200.202.402', 'Data Warehouse / OLAP', 0, 6, 'MKP', 'Business Intelligence', 'data,warehouse,olap,etl,datawarehouse'),
('Sistem Informasi', '200.202.403', 'Knowledge Management', 0, 6, 'MKP', 'E-Business', 'knowledge,management,km,pengetahuan');

-- Semester 7 (18 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Sistem Informasi', '200.201.319', 'Manajemen Proyek Sistem Informasi', 3, 7, 'MKWP', '', 'manajemen,proyek,sistem,informasi,project'),
('Sistem Informasi', '200.201.320', 'Manajemen Risiko dan Kualitas SI', 3, 7, 'MKWP', '', 'manajemen,risiko,kualitas,sistem,informasi,risk'),
('Sistem Informasi', '200.201.321', 'Tata Kelola dan Audit Sistem Informasi', 3, 7, 'MKWP', '', 'tata,kelola,audit,sistem,informasi,governance'),
('Sistem Informasi', '200.201.322', 'Testing dan Implementasi SI', 3, 7, 'MKWP', '', 'testing,implementasi,sistem,informasi,uji'),
('Sistem Informasi', '200.201.323', 'Pemrograman Berbasis Mobile', 3, 7, 'MKWP', '', 'pemrograman,mobile,android,ios,bergerak'),
('Sistem Informasi', '', 'Mata Kuliah Pilihan 3', 3, 7, 'MKP', '', 'pilihan'),
('Sistem Informasi', '200.201.404', 'Analisis Media Sosial', 0, 7, 'MKP', 'Business Intelligence', 'analisis,media,sosial,social,media,analytics'),
('Sistem Informasi', '200.201.405', 'E-Government', 0, 7, 'MKP', 'E-Business', 'e-government,egovernment,pemerintahan,digital');

-- Semester 8 (15 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Sistem Informasi', '200.202.324', 'Tugas Akhir', 6, 8, 'MKWP', '', 'tugas,akhir,skripsi,thesis'),
('Sistem Informasi', '200.202.325', 'Interpersonal Skill', 2, 8, 'MKWP', '', 'interpersonal,skill,softskill,komunikasi'),
('Sistem Informasi', '200.202.326', 'Inovasi Kreatif Digital', 2, 8, 'MKWP', '', 'inovasi,kreatif,digital,creative'),
('Sistem Informasi', '200.202.327', 'Etika Profesi Sistem Informasi', 2, 8, 'MKWP', '', 'etika,profesi,sistem,informasi,profesional'),
('Sistem Informasi', '', 'Mata Kuliah Pilihan 4', 3, 8, 'MKP', '', 'pilihan'),
('Sistem Informasi', '200.202.406', 'Financial Technology', 0, 8, 'MKP', 'E-Business', 'financial,technology,fintech,keuangan,digital'),
('Sistem Informasi', '200.202.407', 'Big Data For Business', 0, 8, 'MKP', 'Business Intelligence', 'big,data,business,bigdata,analytics');

-- =============================================
-- INFORMATIKA (144 SKS, 8 Semester)
-- =============================================

-- Semester 1 (19 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Informatika', '200001104', 'Bahasa Inggris', 2, 1, 'MKU', '', 'bahasa,inggris,english'),
('Informatika', '200001108', 'ICT Literacy', 2, 1, 'MKU', '', 'ict,literacy,komputer,dasar,teknologi'),
('Informatika', '200301201', 'Algoritma dan Pemrograman', 3, 1, 'MKWP', '', 'algoritma,pemrograman,programming,coding'),
('Informatika', '200301202', 'Aljabar Linier', 2, 1, 'MKWP', '', 'aljabar,linear,linier,matriks,vektor'),
('Informatika', '200301203', 'Arsitektur dan Organisasi Komputer', 3, 1, 'MKWP', '', 'arsitektur,organisasi,komputer,hardware'),
('Informatika', '200301204', 'Dasar Pemrograman', 2, 1, 'MKWP', '', 'dasar,pemrograman,programming,coding'),
('Informatika', '200301205', 'Pemrograman Visual', 3, 1, 'MKWP', '', 'pemrograman,visual,gui,desktop'),
('Informatika', '200301206', 'Pengantar Teknologi Komunikasi dan Informatika', 2, 1, 'MKWP', '', 'pengantar,teknologi,komunikasi,informatika');

-- Semester 2 (19 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Informatika', '200002106', 'Estetika Humanisme', 2, 2, 'MKU', '', 'estetika,humanisme,humaniora'),
('Informatika', '200002101', 'Pendidikan Pancasila', 2, 2, 'MKU', '', 'pancasila,pendidikan'),
('Informatika', '200302207', 'Kalkulus', 3, 2, 'MKWP', '', 'kalkulus,calculus,turunan,integral'),
('Informatika', '200302208', 'Statistika dan Probabilitas', 3, 2, 'MKWP', '', 'statistika,probabilitas,statistik,data'),
('Informatika', '200302209', 'Sistem Basis Data', 3, 2, 'MKWP', '', 'sistem,basis,data,database,sql,mysql'),
('Informatika', '200302210', 'Struktur Data dan Algoritma', 3, 2, 'MKWP', '', 'struktur,data,algoritma,array,linked list'),
('Informatika', '200302211', 'Pemrograman Web I', 3, 2, 'MKWP', '', 'pemrograman,web,html,css,javascript');

-- Semester 3 (18 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Informatika', '200001107', 'Pendidikan Agama', 2, 3, 'MKU', '', 'agama,pendidikan,agama'),
('Informatika', '200001105', 'Pendidikan Kewarganegaraan', 2, 3, 'MKU', '', 'pendidikan,kewarganegaraan,pkn'),
('Informatika', '200301301', 'Sistem Digital', 3, 3, 'MKWP', '', 'sistem,digital,logika,gerbang'),
('Informatika', '200301212', 'Matematika Diskrit', 3, 3, 'MKWP', '', 'matematika,diskrit,logika,himpunan'),
('Informatika', '200301213', 'Sistem Operasi', 3, 3, 'MKWP', '', 'sistem,operasi,operating,system,linux,windows'),
('Informatika', '200301302', 'Dasar Keamanan Komputer', 2, 3, 'MKWP', '', 'dasar,keamanan,komputer,security'),
('Informatika', '200301303', 'Pemrograman PL/SQL', 3, 3, 'MKWP', '', 'pemrograman,plsql,sql,oracle,database');

-- Semester 4 (19 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Informatika', '200002103', 'Bahasa Indonesia', 2, 4, 'MKU', '', 'bahasa,indonesia'),
('Informatika', '200302214', 'Interaksi Manusia Komputer', 2, 4, 'MKWP', '', 'interaksi,manusia,komputer,imk,hci,user,interface'),
('Informatika', '200302215', 'Pemrograman Web II', 3, 4, 'MKWP', '', 'pemrograman,web,html,css,javascript,php,lanjut'),
('Informatika', '200302304', 'Sistem Jaringan I', 3, 4, 'MKWP', '', 'sistem,jaringan,network,lan,wan'),
('Informatika', '200302216', 'Analisa Berorientasi Objek', 3, 4, 'MKWP', '', 'analisa,berorientasi,objek,oop,uml'),
('Informatika', '200302305', 'Data Science', 3, 4, 'MKWP', '', 'data,science,analitik,python,jupyter'),
('Informatika', '200302306', 'Komunikasi Data', 3, 4, 'MKWP', '', 'komunikasi,data,jaringan,network,protocol');

-- Semester 5 (18 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Informatika', '200301401', 'Machine Learning', 3, 5, 'MKP', 'Data Science', 'machine,learning,ml,supervised,unsupervised'),
('Informatika', '200301406', 'Sistem Jaringan II', 3, 5, 'MKP', 'Network Specialist', 'sistem,jaringan,network,routing,switching'),
('Informatika', '200301402', 'Deep Learning', 3, 5, 'MKP', 'Data Science', 'deep,learning,neural,network,cnn,rnn'),
('Informatika', '200301407', 'Jaringan Wireless dan Mobile', 3, 5, 'MKP', 'Network Specialist', 'jaringan,wireless,mobile,wifi,nirkabel'),
('Informatika', '200301307', 'Data Mining', 3, 5, 'MKWP', '', 'data,mining,penambangan,data,pattern'),
('Informatika', '200301308', 'Kriptografi dan Steganografi', 3, 5, 'MKWP', '', 'kriptografi,steganografi,enkripsi,keamanan'),
('Informatika', '200301309', 'Kecerdasan Buatan', 3, 5, 'MKWP', '', 'kecerdasan,buatan,artificial,intelligence,ai'),
('Informatika', '200301217', 'Pemrograman Berorientasi Objek', 3, 5, 'MKWP', '', 'pemrograman,berorientasi,objek,oop,java,class');

-- Semester 6 (18 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Informatika', '200002102', 'Pendidikan Kewirausahaan', 2, 6, 'MKU', '', 'kewirausahaan,wirausaha,entrepreneurship'),
('Informatika', '200302218', 'Rekayasa Perangkat Lunak', 3, 6, 'MKWP', '', 'rekayasa,perangkat,lunak,software,engineering'),
('Informatika', '200302219', 'Kerja Praktik', 4, 6, 'MKWP', '', 'kerja,praktik,magang,internship'),
('Informatika', '200302220', 'IoT (Internet of Things)', 3, 6, 'MKWP', '', 'iot,internet,things,sensor,embedded'),
('Informatika', '200302310', 'Teori Informasi', 3, 6, 'MKWP', '', 'teori,informasi,information,theory'),
('Informatika', '200302311', 'Grafika Komputer', 3, 6, 'MKWP', '', 'grafika,komputer,graphics,3d,rendering');

-- Semester 7 (18 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Informatika', '200301403', 'Natural Language Processing', 3, 7, 'MKP', 'Data Science', 'natural,language,processing,nlp,text'),
('Informatika', '200301408', 'Sistem Operasi Jaringan dan Konfigurasi Server', 3, 7, 'MKP', 'Network Specialist', 'sistem,operasi,jaringan,server,konfigurasi'),
('Informatika', '200301404', 'Kecerdasan Komputasional', 3, 7, 'MKP', 'Data Science', 'kecerdasan,komputasional,computational,intelligence'),
('Informatika', '200301409', 'Network Programming & Administration', 3, 7, 'MKP', 'Network Specialist', 'network,programming,administration,admin'),
('Informatika', '200301312', 'Cloud Computing', 3, 7, 'MKWP', '', 'cloud,computing,aws,azure,gcp'),
('Informatika', '200301313', 'Proyek Perancangan dan Pengembangan TIK', 3, 7, 'MKWP', '', 'proyek,perancangan,pengembangan,tik'),
('Informatika', '200301314', 'Metodologi Penelitian TI', 3, 7, 'MKWP', '', 'metodologi,penelitian,riset,teknologi,informasi'),
('Informatika', '200301315', 'Pemrograman Bergerak', 3, 7, 'MKWP', '', 'pemrograman,bergerak,mobile,android,ios');

-- Semester 8 (15 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Informatika', '200302405', 'Pengolahan Citra', 3, 8, 'MKP', 'Data Science', 'pengolahan,citra,image,processing'),
('Informatika', '200302410', 'Jaringan VOIP', 3, 8, 'MKP', 'Network Specialist', 'jaringan,voip,voice,ip,telepon'),
('Informatika', '200302316', 'Sistem Multimedia', 3, 8, 'MKWP', '', 'sistem,multimedia,audio,video,media'),
('Informatika', '200302317', 'Sistem Pakar', 3, 8, 'MKWP', '', 'sistem,pakar,expert,system,ai'),
('Informatika', '200302318', 'Tugas Akhir', 6, 8, 'MKWP', '', 'tugas,akhir,skripsi,thesis');

-- =============================================
-- MANAJEMEN (144 SKS, 8 Semester)
-- =============================================

-- Semester 1 (21 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Manajemen', '', 'Pengantar Teknologi Informasi', 3, 1, 'MKWP', '', 'pengantar,teknologi,informasi,ti,komputer'),
('Manajemen', '', 'Pengantar Manajemen Rantai Pasok', 3, 1, 'MKWP', '', 'pengantar,manajemen,rantai,pasok,supply,chain'),
('Manajemen', '', 'Ekonomi Mikro', 3, 1, 'MKWP', '', 'ekonomi,mikro,microeconomics,pasar,permintaan'),
('Manajemen', '', 'Pengantar Akuntansi 1', 3, 1, 'MKWP', '', 'pengantar,akuntansi,accounting,jurnal,neraca'),
('Manajemen', '', 'Matematika Ekonomi dan Bisnis', 3, 1, 'MKWP', '', 'matematika,ekonomi,bisnis,kalkulus'),
('Manajemen', '', 'Bahasa Inggris', 2, 1, 'MKDU', '', 'bahasa,inggris,english'),
('Manajemen', '', 'ICT Literacy', 2, 1, 'MKDU', '', 'ict,literacy,komputer,dasar,teknologi');

-- Semester 2 (18 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Manajemen', '', 'Pasar dan Lembaga Keuangan', 2, 2, 'MKWP', '', 'pasar,lembaga,keuangan,bank,bursa'),
('Manajemen', '', 'Estetika Humanisme', 2, 2, 'MKDU', '', 'estetika,humanisme,humaniora'),
('Manajemen', '', 'Pengantar Bisnis', 3, 2, 'MKWP', '', 'pengantar,bisnis,business,entrepreneurship'),
('Manajemen', '', 'Pancasila', 2, 2, 'MKDU', '', 'pancasila,pendidikan'),
('Manajemen', '', 'Pengantar Akuntansi 2', 3, 2, 'MKWP', '', 'pengantar,akuntansi,accounting,lanjutan'),
('Manajemen', '', 'Ekonomi Makro', 3, 2, 'MKWP', '', 'ekonomi,makro,macroeconomics,gdp,inflasi'),
('Manajemen', '', 'Statistik Ekonomi dan Bisnis 1', 3, 2, 'MKWP', '', 'statistik,ekonomi,bisnis,data,analisis');

-- Semester 3 (21 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Manajemen', '', 'Agama', 2, 3, 'MKDU', '', 'agama,pendidikan,agama'),
('Manajemen', '', 'Kewarganegaraan', 2, 3, 'MKDU', '', 'pendidikan,kewarganegaraan,pkn'),
('Manajemen', '', 'Manajemen SDM 1', 3, 3, 'MKK', '', 'manajemen,sdm,sumber,daya,manusia,hrm'),
('Manajemen', '', 'Digital Marketing', 3, 3, 'MKK', '', 'digital,marketing,pemasaran,online,sosmed'),
('Manajemen', '', 'Manajemen Operasional 1', 3, 3, 'MKK', '', 'manajemen,operasional,operasi,produksi'),
('Manajemen', '', 'Manajemen Keuangan 1', 3, 3, 'MKK', '', 'manajemen,keuangan,finance,investasi'),
('Manajemen', '', 'Statistik Ekonomi dan Bisnis 2', 3, 3, 'MKWP', '', 'statistik,ekonomi,bisnis,lanjutan,regresi'),
('Manajemen', '', 'Bahasa Korea', 2, 3, 'MKDU', '', 'bahasa,korea,korean');

-- Semester 4 (19 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Manajemen', '', 'Manajemen SDM 2', 3, 4, 'MKK', '', 'manajemen,sdm,sumber,daya,manusia,lanjutan'),
('Manajemen', '', 'Advanced Digital Marketing', 3, 4, 'MKK', '', 'advanced,digital,marketing,pemasaran,lanjutan'),
('Manajemen', '', 'Manajemen Operasional 2', 3, 4, 'MKK', '', 'manajemen,operasional,operasi,lanjutan'),
('Manajemen', '', 'Manajemen Perbankan', 3, 4, 'MKWP', '', 'manajemen,perbankan,bank,keuangan'),
('Manajemen', '', 'Perekonomian Indonesia', 2, 4, 'MKWP', '', 'perekonomian,indonesia,ekonomi,nasional'),
('Manajemen', '', 'Bahasa Indonesia', 2, 4, 'MKU', '', 'bahasa,indonesia'),
('Manajemen', '', 'Manajemen Keuangan 2', 3, 4, 'MKK', '', 'manajemen,keuangan,finance,lanjutan');

-- Semester 5 (20 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Manajemen', '', 'Digital Innovative Entrepreneurship', 3, 5, 'MKWP', '', 'digital,innovative,entrepreneurship,kewirausahaan'),
('Manajemen', '', 'Manajemen Risiko', 3, 5, 'MKK', '', 'manajemen,risiko,risk,management'),
('Manajemen', '', 'Akuntansi Biaya', 3, 5, 'MKWP', '', 'akuntansi,biaya,cost,accounting'),
('Manajemen', '', 'Perpajakan', 2, 5, 'MKWP', '', 'perpajakan,pajak,tax,fiskal'),
('Manajemen', '', 'E-Commerce Business', 3, 5, 'MKWP', '', 'e-commerce,ecommerce,bisnis,online,marketplace'),
('Manajemen', '', 'Hukum Bisnis', 3, 5, 'MKWP', '', 'hukum,bisnis,law,business,kontrak'),
('Manajemen', '', 'Sistem Informasi Manajemen', 3, 5, 'MKWP', '', 'sistem,informasi,manajemen,sim,mis');

-- Semester 6 (19 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Manajemen', '', 'Metode Penelitian Manajemen', 3, 6, 'MKWP', '', 'metode,penelitian,manajemen,riset,skripsi'),
('Manajemen', '', 'Akuntansi Manajemen', 3, 6, 'MKK', '', 'akuntansi,manajemen,management,accounting'),
('Manajemen', '', 'Anggaran Bisnis', 3, 6, 'MKWP', '', 'anggaran,bisnis,budget,budgeting'),
('Manajemen', '', 'Business Communication', 2, 6, 'MKK', '', 'business,communication,komunikasi,bisnis'),
('Manajemen', '', 'Organizational Behavior', 3, 6, 'MKWP', '', 'organizational,behavior,perilaku,organisasi'),
('Manajemen', '', 'Kewirausahaan', 2, 6, 'MKU', '', 'kewirausahaan,wirausaha,entrepreneurship'),
('Manajemen', '', 'Studi Kelayakan Bisnis', 3, 6, 'MKWP', '', 'studi,kelayakan,bisnis,feasibility,study');

-- Semester 7 (17 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Manajemen', '', 'Manajemen Strategik', 3, 7, 'MKWP', '', 'manajemen,strategik,strategic,management,strategi'),
('Manajemen', '', 'Etika Bisnis', 2, 7, 'MKWP', '', 'etika,bisnis,business,ethics'),
('Manajemen', '', 'Bisnis Internasional', 3, 7, 'MKWP', '', 'bisnis,internasional,international,business,global'),
('Manajemen', '', 'Manajemen Kinerja dan Kompensasi', 3, 7, 'MKP', 'Manajemen SDM', 'manajemen,kinerja,kompensasi,performance'),
('Manajemen', '', 'Manajemen Hubungan Industrial', 3, 7, 'MKP', 'Manajemen SDM', 'manajemen,hubungan,industrial,serikat,pekerja'),
('Manajemen', '', 'Manajemen SDM Internasional', 3, 7, 'MKP', 'Manajemen SDM', 'manajemen,sdm,internasional,global,hr'),
('Manajemen', '', 'Riset Pemasaran Digital', 3, 7, 'MKP', 'Manajemen Pemasaran', 'riset,pemasaran,digital,marketing,research'),
('Manajemen', '', 'Perilaku Konsumen Digital', 3, 7, 'MKP', 'Manajemen Pemasaran', 'perilaku,konsumen,digital,consumer,behavior'),
('Manajemen', '', 'Pemasaran Global', 3, 7, 'MKP', 'Manajemen Pemasaran', 'pemasaran,global,international,marketing'),
('Manajemen', '', 'Manajemen Investasi', 3, 7, 'MKP', 'Manajemen Keuangan', 'manajemen,investasi,investment,saham,portofolio'),
('Manajemen', '', 'Riset Keuangan Digital', 3, 7, 'MKP', 'Manajemen Keuangan', 'riset,keuangan,digital,finance,research'),
('Manajemen', '', 'Manajemen Keuangan Internasional', 3, 7, 'MKP', 'Manajemen Keuangan', 'manajemen,keuangan,internasional,international,finance'),
('Manajemen', '', 'Manajemen Proyek', 3, 7, 'MKP', 'Manajemen Operasional', 'manajemen,proyek,project,management'),
('Manajemen', '', 'Manajemen Retail', 3, 7, 'MKP', 'Manajemen Operasional', 'manajemen,retail,ritel,toko'),
('Manajemen', '', 'Manajemen Operasi Internasional', 3, 7, 'MKP', 'Manajemen Operasional', 'manajemen,operasi,internasional,global,operations');

-- Semester 8 (10 SKS)
INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Manajemen', '', 'Tugas Akhir', 6, 8, 'MKWP', '', 'tugas,akhir,skripsi,thesis'),
('Manajemen', '', 'Cyber Security Management', 2, 8, 'MKWP', '', 'cyber,security,management,keamanan,siber'),
('Manajemen', '', 'Business Intelligence', 2, 8, 'MKWP', '', 'business,intelligence,bi,data,analitik');

-- =============================================
-- AKUNTANSI (144 SKS, 8 Semester)
-- =============================================

INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Akuntansi', '200.401.101', 'Pengantar Akuntansi 1', 3, 1, 'MKWP', '', 'pengantar,akuntansi,accounting,jurnal,neraca'),
('Akuntansi', '200.401.102', 'Pengantar Perpajakan', 3, 1, 'MKWP', '', 'pengantar,perpajakan,pajak,tax'),
('Akuntansi', '200.401.103', 'Ekonomi Mikro', 3, 1, 'MKWP', '', 'ekonomi,mikro,microeconomics,pasar'),
('Akuntansi', '200.401.104', 'Matematika Ekonomi dan Bisnis', 3, 1, 'MKWP', '', 'matematika,ekonomi,bisnis,kalkulus'),
('Akuntansi', '200.402.203', 'Pengantar Manajemen', 3, 1, 'MKWP', '', 'pengantar,manajemen,management'),
('Akuntansi', '200.501.104', 'Bahasa Inggris', 2, 1, 'MKU', '', 'bahasa,inggris,english'),
('Akuntansi', '200.001.108', 'ICT Literacy', 2, 1, 'MKU', '', 'ict,literacy,komputer,dasar,teknologi'),
('Akuntansi', '200.402.201', 'Pengantar Akuntansi 2', 3, 2, 'MKWP', '', 'pengantar,akuntansi,lanjutan,accounting'),
('Akuntansi', '200.402.202', 'Ekonomi Makro', 3, 2, 'MKWP', '', 'ekonomi,makro,macroeconomics,gdp,inflasi'),
('Akuntansi', '200.402.204', 'Ketentuan Umum dan Tata Cara Perpajakan (KUP)', 3, 2, 'MKWP', '', 'ketentuan,umum,tata,cara,perpajakan,kup'),
('Akuntansi', '200.402.205', 'Perpajakan 1', 3, 2, 'MKWP', '', 'perpajakan,pajak,tax,pph,ppn'),
('Akuntansi', '200.402.206', 'Statistik Ekonomi dan Bisnis', 3, 2, 'MKWP', '', 'statistik,ekonomi,bisnis,data,analisis'),
('Akuntansi', '200.002.101', 'Pendidikan Pancasila', 2, 2, 'MKU', '', 'pancasila,pendidikan'),
('Akuntansi', '200.002.106', 'Estetika Humanisme', 2, 2, 'MKU', '', 'estetika,humanisme,humaniora'),
('Akuntansi', '200.401.301', 'Akuntansi Keuangan 1', 3, 3, 'MKKP', '', 'akuntansi,keuangan,financial,accounting'),
('Akuntansi', '200.401.207', 'Digital Marketing', 3, 3, 'MKWP', '', 'digital,marketing,pemasaran,online'),
('Akuntansi', '200.401.208', 'Akuntansi Biaya', 3, 3, 'MKWP', '', 'akuntansi,biaya,cost,accounting'),
('Akuntansi', '200.401.302', 'Kepabeanan dan Cukai', 3, 3, 'MKKP', '', 'kepabeanan,cukai,customs,ekspor,impor'),
('Akuntansi', '200.401.303', 'Perpajakan 2', 3, 3, 'MKKP', '', 'perpajakan,pajak,tax,lanjutan,pph'),
('Akuntansi', '200.501.102', 'Pendidikan Kewarganegaraan', 2, 3, 'MKU', '', 'pendidikan,kewarganegaraan,pkn'),
('Akuntansi', '200.501.107', 'Pendidikan Agama', 2, 3, 'MKU', '', 'agama,pendidikan,agama'),
('Akuntansi', '210.301.109', 'Bahasa Korea', 2, 3, 'MKU', '', 'bahasa,korea,korean'),
('Akuntansi', '200.402.304', 'Akuntansi Keuangan 2', 3, 4, 'MKKP', '', 'akuntansi,keuangan,financial,accounting,lanjutan'),
('Akuntansi', '200.402.209', 'Akuntansi Manajemen', 3, 4, 'MKWP', '', 'akuntansi,manajemen,management,accounting'),
('Akuntansi', '200.402.210', 'Manajemen Rantai Pasok', 3, 4, 'MKWP', '', 'manajemen,rantai,pasok,supply,chain'),
('Akuntansi', '200.402.211', 'E-Commerce Business', 2, 4, 'MKWP', '', 'e-commerce,ecommerce,bisnis,online'),
('Akuntansi', '200.402.212', 'Manajemen Keuangan 1', 3, 4, 'MKWP', '', 'manajemen,keuangan,finance'),
('Akuntansi', '200.402.213', 'Akuntansi Sektor Publik', 3, 4, 'MKWP', '', 'akuntansi,sektor,publik,pemerintah,public'),
('Akuntansi', '200.402.214', 'Komunikasi Bisnis', 2, 4, 'MKWP', '', 'komunikasi,bisnis,business,communication'),
('Akuntansi', '200.002.103', 'Bahasa Indonesia', 2, 4, 'MKU', '', 'bahasa,indonesia'),
('Akuntansi', '200.401.215', 'Manajemen Keuangan 2', 3, 5, 'MKWP', '', 'manajemen,keuangan,finance,lanjutan'),
('Akuntansi', '200.401.216', 'Sistem Informasi Akuntansi', 3, 5, 'MKWP', '', 'sistem,informasi,akuntansi,sia,accounting'),
('Akuntansi', '200.401.217', 'Perilaku Organisasi', 2, 5, 'MKWP', '', 'perilaku,organisasi,organizational,behavior'),
('Akuntansi', '200.401.218', 'Teori Akuntansi', 3, 5, 'MKWP', '', 'teori,akuntansi,accounting,theory'),
('Akuntansi', '200.401.219', 'Analisis Sekuritas dan Portofolio', 3, 5, 'MKWP', '', 'analisis,sekuritas,portofolio,saham,investasi'),
('Akuntansi', '200.401.220', 'Praktikum Perpajakan', 2, 5, 'MKWP', '', 'praktikum,perpajakan,pajak,tax,praktik'),
('Akuntansi', '200.401.222', 'Manajemen Stratejik', 2, 5, 'MKWP', '', 'manajemen,strategik,strategi,strategic'),
('Akuntansi', '200.402.223', 'Manajemen Risiko', 3, 6, 'MKWP', '', 'manajemen,risiko,risk,management'),
('Akuntansi', '200.402.224', 'Metode Penelitian Akuntansi', 3, 6, 'MKWP', '', 'metode,penelitian,akuntansi,riset,research'),
('Akuntansi', '200.402.305', 'Digital Auditing 1', 3, 6, 'MKKP', '', 'digital,auditing,audit,pemeriksaan'),
('Akuntansi', '200.402.225', 'Digital Audit Internal', 3, 6, 'MKWP', '', 'digital,audit,internal,pemeriksaan'),
('Akuntansi', '200.402.306', 'Akuntansi Keuangan Lanjutan 1', 3, 6, 'MKKP', '', 'akuntansi,keuangan,lanjutan,advanced'),
('Akuntansi', '200.401.221', 'Hukum Bisnis', 2, 6, 'MKWP', '', 'hukum,bisnis,law,business,kontrak'),
('Akuntansi', '200.002.102', 'Pendidikan Kewirausahaan', 2, 6, 'MKU', '', 'kewirausahaan,wirausaha,entrepreneurship'),
('Akuntansi', '200.402.228', 'Praktikum Akuntansi Berbasis IT', 2, 6, 'MKWP', '', 'praktikum,akuntansi,it,komputer,software'),
('Akuntansi', '200.401.308', 'Digital Auditing 2', 3, 7, 'MKKP', '', 'digital,auditing,audit,pemeriksaan,lanjutan'),
('Akuntansi', '200.401.226', 'Sistem Pengendalian Manajemen', 2, 7, 'MKWP', '', 'sistem,pengendalian,manajemen,internal,control'),
('Akuntansi', '200.401.401', 'Kepemimpinan dan Etika Bisnis', 3, 7, 'MKP', '', 'kepemimpinan,etika,bisnis,leadership,ethics'),
('Akuntansi', '200.401.402', 'Akuntansi Keuangan Lanjutan 2', 3, 7, 'MKP', 'Akuntansi Keuangan', 'akuntansi,keuangan,lanjutan,advanced,konsolidasi'),
('Akuntansi', '200.401.403', 'Praktek Akuntansi dan Bisnis Kontemporer', 3, 7, 'MKP', 'Akuntansi Keuangan', 'praktek,akuntansi,bisnis,kontemporer'),
('Akuntansi', '200.401.404', 'Akuntansi Keuangan Berkelanjutan', 3, 7, 'MKP', 'Akuntansi Keuangan', 'akuntansi,keuangan,berkelanjutan,sustainability'),
('Akuntansi', '200.401.405', 'Perpajakan Internasional', 3, 7, 'MKP', 'Perpajakan', 'perpajakan,internasional,international,tax'),
('Akuntansi', '200.401.406', 'Manajemen Perpajakan', 3, 7, 'MKP', 'Perpajakan', 'manajemen,perpajakan,tax,planning'),
('Akuntansi', '200.401.407', 'Akuntansi Perpajakan', 3, 7, 'MKP', 'Perpajakan', 'akuntansi,perpajakan,tax,accounting'),
('Akuntansi', '200.401.408', 'Audit Forensik Digital dan Audit Investigasi', 3, 7, 'MKP', 'Pengauditan', 'audit,forensik,digital,investigasi,fraud'),
('Akuntansi', '200.401.409', 'Analisis Laporan Keuangan berbasis IT', 3, 7, 'MKP', 'Pengauditan', 'analisis,laporan,keuangan,it,financial'),
('Akuntansi', '200.401.410', 'Audit Sistem Informasi', 3, 7, 'MKP', 'Pengauditan', 'audit,sistem,informasi,it,audit'),
('Akuntansi', '200.402.227', 'Corporate Governance', 2, 8, 'MKWP', '', 'corporate,governance,tata,kelola,perusahaan'),
('Akuntansi', '200.402.228b', 'Skripsi', 6, 8, 'MKWP', '', 'skripsi,tugas,akhir,thesis'),
('Akuntansi', '200.402.307', 'Special Topics in Accounting', 2, 8, 'MKKP', '', 'special,topics,accounting,akuntansi,khusus');

-- =============================================
-- KOMUNIKASI (144 SKS, 8 Semester)
-- =============================================

INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Komunikasi', '200501104', 'Bahasa Inggris', 2, 1, '', '', 'bahasa,inggris,english'),
('Komunikasi', '200501108', 'ICT Literacy', 2, 1, '', '', 'ict,literacy,komputer,dasar,teknologi'),
('Komunikasi', '200501301', 'Dasar-Dasar Jurnalistik', 3, 1, '', '', 'dasar,jurnalistik,jurnalisme,berita,news'),
('Komunikasi', '200501302', 'Dasar-Dasar Videografi', 3, 1, '', '', 'dasar,videografi,video,kamera,shooting'),
('Komunikasi', '200501201', 'Pengantar Komunikasi Digital', 3, 1, '', '', 'pengantar,komunikasi,digital,media'),
('Komunikasi', '200501202', 'Komunikasi Massa', 2, 1, '', '', 'komunikasi,massa,media,mass,communication'),
('Komunikasi', '200501303', 'Pengantar Corporate Communication', 3, 1, '', '', 'pengantar,corporate,communication,perusahaan'),
('Komunikasi', '200002206', 'Estetika Humanisme', 2, 2, '', '', 'estetika,humanisme,humaniora'),
('Komunikasi', '200502101', 'Pendidikan Pancasila', 2, 2, '', '', 'pancasila,pendidikan'),
('Komunikasi', '200502203', 'Teori Komunikasi Digital', 3, 2, '', '', 'teori,komunikasi,digital,media'),
('Komunikasi', '200502304', 'Videografi Jurnalistik dan Periklanan', 3, 2, '', '', 'videografi,jurnalistik,periklanan,iklan,video'),
('Komunikasi', '200502305', 'Digital Imaging', 3, 2, '', '', 'digital,imaging,foto,gambar,photoshop'),
('Komunikasi', '200502306', 'Digital Marketing Communication', 3, 2, '', '', 'digital,marketing,communication,pemasaran'),
('Komunikasi', '200502204', 'Komunikasi Antarpribadi dan Budaya Siber', 3, 2, '', '', 'komunikasi,antarpribadi,budaya,siber,interpersonal'),
('Komunikasi', '200501102', 'Pendidikan Kewarganegaraan', 2, 3, '', '', 'pendidikan,kewarganegaraan,pkn'),
('Komunikasi', '210501109', 'Bahasa Korea', 2, 3, '', '', 'bahasa,korea,korean'),
('Komunikasi', '200501107', 'Pendidikan Agama', 2, 3, '', '', 'agama,pendidikan,agama'),
('Komunikasi', '200501205', 'Public Speaking dan Presentation', 3, 3, '', '', 'public,speaking,presentation,pidato,presentasi'),
('Komunikasi', '200501307', 'Cyber Journalism', 3, 3, '', '', 'cyber,journalism,jurnalisme,digital,online'),
('Komunikasi', '200501308', 'Copywriting Digital', 3, 3, '', '', 'copywriting,digital,menulis,konten,content'),
('Komunikasi', '200501309', 'Cyber Public Relations', 3, 3, '', '', 'cyber,public,relations,humas,pr,digital'),
('Komunikasi', '200501206', 'Regulasi Komunikasi Digital', 3, 3, '', '', 'regulasi,komunikasi,digital,hukum,uu,ite'),
('Komunikasi', '200002103', 'Bahasa Indonesia', 2, 4, '', '', 'bahasa,indonesia'),
('Komunikasi', '200502206', 'Statistika Sosial', 3, 4, '', '', 'statistika,sosial,statistik,data,penelitian'),
('Komunikasi', '200502310', 'Reportase dan Penulisan Naskah', 3, 4, '', '', 'reportase,penulisan,naskah,jurnalistik,berita'),
('Komunikasi', '200502311', 'Kajian Media Digital', 3, 4, '', '', 'kajian,media,digital,analisis,media'),
('Komunikasi', '200502207', 'Desain Komunikasi Visual', 2, 4, '', '', 'desain,komunikasi,visual,dkv,grafis'),
('Komunikasi', '200502312', 'Manajemen Public Relations', 3, 4, '', '', 'manajemen,public,relations,humas,pr'),
('Komunikasi', '200502208', 'Psikologi Komunikasi Digital', 3, 4, '', '', 'psikologi,komunikasi,digital,perilaku'),
('Komunikasi', '200501208', 'Komunikasi Politik', 3, 5, '', '', 'komunikasi,politik,political,communication'),
('Komunikasi', '200501209', 'Literasi Media Digital', 3, 5, '', '', 'literasi,media,digital,literacy'),
('Komunikasi', '200501313', 'Podcast dan Radio Digital', 3, 5, '', '', 'podcast,radio,digital,audio,streaming'),
('Komunikasi', '200501212', 'Metode Penelitian Kuantitatif', 3, 5, '', '', 'metode,penelitian,kuantitatif,statistik,survey'),
('Komunikasi', '200501314', 'Marketing Public Relations', 3, 5, '', '', 'marketing,public,relations,pemasaran,pr'),
('Komunikasi', '200501315', 'Strategi Komunikasi Digital', 3, 5, '', '', 'strategi,komunikasi,digital,planning'),
('Komunikasi', '200502105', 'Kewirausahaan', 2, 6, '', '', 'kewirausahaan,wirausaha,entrepreneurship'),
('Komunikasi', '200502210', 'Metode Penelitian Kualitatif', 3, 6, '', '', 'metode,penelitian,kualitatif,wawancara,observasi'),
('Komunikasi', '200502316', 'Produksi Media Digital Kreatif', 3, 6, '', '', 'produksi,media,digital,kreatif,konten'),
('Komunikasi', '200502213', 'Social Media Content Writing', 3, 6, '', '', 'social,media,content,writing,konten,sosmed'),
('Komunikasi', '200502319', 'Special Event Organizer', 3, 6, '', '', 'special,event,organizer,eo,acara'),
('Komunikasi', '200502214', 'Digital Society Communication', 3, 6, '', '', 'digital,society,communication,masyarakat'),
('Komunikasi', '200502211', 'Creative Grafis Design', 2, 6, '', '', 'creative,grafis,design,desain,photoshop'),
('Komunikasi', '200501215', 'Filsafat Komunikasi Digital', 3, 7, '', '', 'filsafat,komunikasi,digital,philosophy'),
('Komunikasi', '200501320', 'Seminar Komunikasi Media Digital', 3, 7, 'MKP', 'Digital Content Creative', 'seminar,komunikasi,media,digital'),
('Komunikasi', '200501321', 'Seminar Corporate Communication', 3, 7, 'MKP', 'Corporate Communication', 'seminar,corporate,communication,perusahaan'),
('Komunikasi', '200501322', 'Campaign Digital dan Publisitas', 3, 7, '', '', 'campaign,digital,publisitas,kampanye'),
('Komunikasi', '200501323', 'Produksi Video Kreatif Digital', 3, 7, '', '', 'produksi,video,kreatif,digital,youtube'),
('Komunikasi', '200501324', 'Corporate Social Responsibility', 3, 7, '', '', 'corporate,social,responsibility,csr'),
('Komunikasi', '200501325', 'Praktek Kerja Komunikasi (PKK)', 3, 7, '', '', 'praktek,kerja,komunikasi,magang,pkk'),
('Komunikasi', '200502401', 'Vlog Production', 3, 8, 'MKP', 'Digital Content Creative', 'vlog,production,youtube,video,konten'),
('Komunikasi', '200502402', 'Social Media Specialist', 2, 8, 'MKP', 'Digital Content Creative', 'social,media,specialist,sosmed'),
('Komunikasi', '200502403', 'Creative Mediapreneur', 2, 8, 'MKP', 'Digital Content Creative', 'creative,mediapreneur,media,entrepreneur'),
('Komunikasi', '200502404', 'Digital Video Editing', 3, 8, 'MKP', 'Digital Content Creative', 'digital,video,editing,premiere,davinci'),
('Komunikasi', '200502405', 'Digital Media Criticism', 2, 8, 'MKP', 'Digital Content Creative', 'digital,media,criticism,kritik,media'),
('Komunikasi', '200502409a', 'Creative Thinking (DCC)', 3, 8, 'MKP', 'Digital Content Creative', 'creative,thinking,kreatif,berpikir'),
('Komunikasi', '200502406', 'Stakeholders Mapping', 3, 8, 'MKP', 'Corporate Communication', 'stakeholders,mapping,pemetaan,pemangku'),
('Komunikasi', '200502407', 'Audit Komunikasi Digital', 2, 8, 'MKP', 'Corporate Communication', 'audit,komunikasi,digital,evaluasi'),
('Komunikasi', '200502408', 'Teknik Lobby dan Negosiasi', 2, 8, 'MKP', 'Corporate Communication', 'teknik,lobby,negosiasi,negotiation'),
('Komunikasi', '200502409b', 'Creative Thinking (CC)', 3, 8, 'MKP', 'Corporate Communication', 'creative,thinking,kreatif,berpikir'),
('Komunikasi', '200502410', 'Komunikasi Krisis dan Reputasi', 3, 8, 'MKP', 'Corporate Communication', 'komunikasi,krisis,reputasi,crisis'),
('Komunikasi', '200502411', 'Writing Public Relations', 2, 8, 'MKP', 'Corporate Communication', 'writing,public,relations,menulis,pr'),
('Komunikasi', '200502412', 'Tugas Akhir / Karya Media Digital', 6, 8, '', '', 'tugas,akhir,karya,media,digital,skripsi');

-- =============================================
-- TEKNOLOGI INFORMASI (144 SKS, 8 Semester)
-- =============================================

INSERT INTO mata_kuliah (prodi, kode_mk, nama_mk, sks, semester, kategori, peminatan, keywords) VALUES
('Teknologi Informasi', '250601001', 'Kalkulus I', 3, 1, 'MKBS', '', 'kalkulus,calculus,turunan,integral'),
('Teknologi Informasi', '250601002', 'Fisika Dasar', 3, 1, 'MKBS', '', 'fisika,dasar,physics,mekanika'),
('Teknologi Informasi', '250601003', 'Bahasa Inggris', 2, 1, 'MKGE', '', 'bahasa,inggris,english'),
('Teknologi Informasi', '250601004', 'Literasi TIK', 2, 1, 'MKWK', '', 'literasi,tik,ict,literacy,komputer'),
('Teknologi Informasi', '250601005', 'Dasar Pemrograman', 3, 1, 'MKBS', '', 'dasar,pemrograman,programming,coding'),
('Teknologi Informasi', '250601006', 'Literasi Kecerdasan Buatan dan Inovasi', 2, 1, 'MKGE', '', 'literasi,kecerdasan,buatan,ai,inovasi'),
('Teknologi Informasi', '250601007', 'Bahasa Indonesia', 3, 1, 'MKWK', '', 'bahasa,indonesia'),
('Teknologi Informasi', '250602008', 'Pancasila', 2, 2, 'MKWK', '', 'pancasila,pendidikan'),
('Teknologi Informasi', '250602009', 'Estetika Humanisme', 2, 2, 'MKWK', '', 'estetika,humanisme,humaniora'),
('Teknologi Informasi', '250602010', 'Teori Informasi', 3, 2, 'MKGE', '', 'teori,informasi,information,theory'),
('Teknologi Informasi', '250602011', 'Matematika Diskrit', 3, 2, 'MKBS', '', 'matematika,diskrit,logika,himpunan'),
('Teknologi Informasi', '250602012', 'Arsitektur dan Organisasi Komputer', 2, 2, 'MKET', '', 'arsitektur,organisasi,komputer,hardware'),
('Teknologi Informasi', '250602013', 'Aljabar Linier', 3, 2, 'MKBS', '', 'aljabar,linear,linier,matriks,vektor'),
('Teknologi Informasi', '250602014', 'Algoritma dan Pemrograman', 3, 2, 'MKBS', '', 'algoritma,pemrograman,programming,coding'),
('Teknologi Informasi', '250603015', 'Agama', 2, 3, 'MKWK', '', 'agama,pendidikan,agama'),
('Teknologi Informasi', '250603016', 'Kewarganegaraan', 2, 3, 'MKWK', '', 'pendidikan,kewarganegaraan,pkn'),
('Teknologi Informasi', '250603017', 'Statistika dan Probabilitas', 3, 3, 'MKET', '', 'statistika,probabilitas,statistik,data'),
('Teknologi Informasi', '250603018', 'Jaringan Komputer', 3, 3, 'MKET', '', 'jaringan,komputer,network,lan,wan'),
('Teknologi Informasi', '250603019', 'Struktur Data', 3, 3, 'MKET', '', 'struktur,data,array,linked list,tree'),
('Teknologi Informasi', '250603020', 'Bahasa Korea', 2, 3, 'MKWK', '', 'bahasa,korea,korean'),
('Teknologi Informasi', '250603021', 'Metode Numerik', 3, 3, 'MKBS', '', 'metode,numerik,numerical,komputasi'),
('Teknologi Informasi', '250604022', 'Sistem Operasi', 2, 4, 'MKET', '', 'sistem,operasi,operating,system,linux,windows'),
('Teknologi Informasi', '250604023', 'Pengantar Keamanan Siber', 2, 4, 'MKBS', '', 'pengantar,keamanan,siber,cyber,security'),
('Teknologi Informasi', '250604024', 'Sistem Digital', 3, 4, 'MKET', '', 'sistem,digital,logika,gerbang'),
('Teknologi Informasi', '250604025', 'Pemrograman SQL', 3, 4, 'MKET', '', 'pemrograman,sql,database,query,mysql'),
('Teknologi Informasi', '250604026', 'Komunikasi Data dan Komputer', 2, 4, 'MKET', '', 'komunikasi,data,komputer,network,protocol'),
('Teknologi Informasi', '250604027', 'Kriptografi dan Steganografi', 3, 4, 'MKET', '', 'kriptografi,steganografi,enkripsi,keamanan'),
('Teknologi Informasi', '250604028', 'Pengembangan Aplikasi Web I', 3, 4, 'MKET', '', 'pengembangan,aplikasi,web,html,css,javascript'),
('Teknologi Informasi', '250605029', 'Pengembangan Aplikasi Web II', 3, 5, 'MKGE', '', 'pengembangan,aplikasi,web,lanjut,php,framework'),
('Teknologi Informasi', '250605030', 'Kalkulus II', 3, 5, 'MKBS', '', 'kalkulus,calculus,lanjut,integral'),
('Teknologi Informasi', '250605031', 'Arsitektur Perusahaan', 3, 5, 'MKET', '', 'arsitektur,perusahaan,enterprise,architecture'),
('Teknologi Informasi', '250605032', 'Manajemen Infrastruktur', 3, 5, 'MKP', 'Pilihan Prodi', 'manajemen,infrastruktur,infrastructure'),
('Teknologi Informasi', '250605033', 'Teknologi Nirkabel', 3, 5, 'MKP', 'Pilihan Prodi', 'teknologi,nirkabel,wireless,wifi'),
('Teknologi Informasi', '250605034', 'Kepemimpinan Digital dan Profesionalisme', 3, 5, 'MKP', 'Pilihan Prodi', 'kepemimpinan,digital,profesionalisme,leadership'),
('Teknologi Informasi', '250605035', 'Arsitektur Jaringan', 3, 5, 'MKET', '', 'arsitektur,jaringan,network,topology'),
('Teknologi Informasi', '250605036', 'Kecerdasan Buatan', 3, 5, 'MKET', '', 'kecerdasan,buatan,artificial,intelligence,ai'),
('Teknologi Informasi', '250606037', 'Manajemen Keamanan Siber', 3, 6, 'MKET', '', 'manajemen,keamanan,siber,cyber,security'),
('Teknologi Informasi', '250606038', 'Komputasi Awan dan Virtualisasi', 3, 6, 'MKET', '', 'komputasi,awan,cloud,computing,virtualisasi'),
('Teknologi Informasi', '250606039', 'Enkripsi Data dan Keamanan', 2, 6, 'MKET', '', 'enkripsi,data,keamanan,encryption,security'),
('Teknologi Informasi', '250606040', 'Kewirausahaan', 2, 6, 'MKWK', '', 'kewirausahaan,wirausaha,entrepreneurship'),
('Teknologi Informasi', '250606041', 'Metodologi Penelitian dan Penulisan Ilmiah', 3, 6, 'MKGE', '', 'metodologi,penelitian,penulisan,ilmiah,riset'),
('Teknologi Informasi', '250606042', 'Sistem Cerdas', 3, 6, 'MKP', 'BDA', 'sistem,cerdas,intelligent,ai'),
('Teknologi Informasi', '250606043', 'Pemrograman Platform dan IoT', 3, 6, 'MKP', 'ISDEV', 'pemrograman,platform,iot,internet,things'),
('Teknologi Informasi', '250606044', 'Keamanan Jaringan', 3, 6, 'MKP', 'NSP', 'keamanan,jaringan,network,security,firewall'),
('Teknologi Informasi', '250606045', 'Pembelajaran Mendalam (Deep Learning)', 3, 6, 'MKP', 'BDA', 'pembelajaran,mendalam,deep,learning,neural'),
('Teknologi Informasi', '250606046', 'Interaksi Manusia Komputer', 2, 6, 'MKGE', '', 'interaksi,manusia,komputer,imk,hci'),
('Teknologi Informasi', '250607047', 'Rekayasa Perangkat Lunak', 2, 7, 'MKET', '', 'rekayasa,perangkat,lunak,software,engineering'),
('Teknologi Informasi', '250607048', 'Proyek Teknologi Informasi', 3, 7, 'MKET', '', 'proyek,teknologi,informasi,project'),
('Teknologi Informasi', '250607049', 'Pemrograman Perangkat Bergerak', 3, 7, 'MKET', '', 'pemrograman,perangkat,bergerak,mobile,android'),
('Teknologi Informasi', '250607050', 'Visi Komputer', 2, 7, 'MKET', '', 'visi,komputer,computer,vision,image'),
('Teknologi Informasi', '250607051', 'Manajemen Layanan TI', 2, 7, 'MKGE', '', 'manajemen,layanan,ti,itil,service'),
('Teknologi Informasi', '250607052', 'Komputasi Tepi (Edge Computing)', 3, 7, 'MKP', 'Pilihan Prodi', 'komputasi,tepi,edge,computing'),
('Teknologi Informasi', '250607053', 'Peretasan Etis (Ethical Hacking)', 3, 7, 'MKP', 'Pilihan Prodi', 'peretasan,etis,ethical,hacking,penetration'),
('Teknologi Informasi', '250607054', 'Komputasi Kuantum', 3, 7, 'MKP', 'Pilihan Prodi', 'komputasi,kuantum,quantum,computing'),
('Teknologi Informasi', '250607055', 'Keamanan Komputasi Awan', 3, 7, 'MKP', 'Pilihan Prodi', 'keamanan,komputasi,awan,cloud,security'),
('Teknologi Informasi', '250607056', 'Forensik Digital', 3, 7, 'MKP', 'Pilihan Prodi', 'forensik,digital,forensic,investigasi'),
('Teknologi Informasi', '250608057', 'Robotika Berbasis Kecerdasan Buatan', 3, 8, 'MKET', '', 'robotika,kecerdasan,buatan,robot,ai'),
('Teknologi Informasi', '250608058', 'Kerja Praktik', 4, 8, 'MKGE', '', 'kerja,praktik,magang,internship'),
('Teknologi Informasi', '250608059', 'Kecerdasan Buatan Generatif', 2, 8, 'MKET', '', 'kecerdasan,buatan,generatif,generative,ai,chatgpt'),
('Teknologi Informasi', '250608060', 'Teknologi Blockchain', 3, 8, 'MKP', 'BDA', 'teknologi,blockchain,crypto,desentralisasi'),
('Teknologi Informasi', '250608061', 'Jaringan Nirkabel', 3, 8, 'MKP', 'ISDEV', 'jaringan,nirkabel,wireless,mobile'),
('Teknologi Informasi', '250608062', 'Keamanan Web dan Aplikasi', 3, 8, 'MKP', 'NSP', 'keamanan,web,aplikasi,owasp,security'),
('Teknologi Informasi', '250608063', 'Model Bahasa Besar (Large Language Model)', 3, 8, 'MKP', 'BDA', 'model,bahasa,besar,llm,gpt,ai,nlp'),
('Teknologi Informasi', '250608064', 'Tugas Akhir', 6, 8, 'MKET', '', 'tugas,akhir,skripsi,thesis');
