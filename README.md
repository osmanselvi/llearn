# English LMS - İngilizce Eğitim Platformu

Native PHP, MySQL ve Bootstrap 5 kullanılarak geliştirilmiş modern bir Öğrenim Yönetim Sistemi (LMS).

## Özellikler
- A1-C1 arası seviye yönetimi.
- Haftalık ders programları.
- Konu anlatımları (Grammar, Vocabulary, Reading).
- Kullanıcı ilerleme takibi.
- Mobil uyumlu tasarım.

## Kurulum
1. Veritabanını oluşturun: `config/schema.sql` dosyasını içe aktarın.
2. `.env` dosyasını düzenleyin.
3. Apache2 yapılandırmasını yapın.

## Güvenlik
- PDO ile SQL Injection koruması.
- XSS filtreleme.
- CSRF koruması (planlanıyor).
