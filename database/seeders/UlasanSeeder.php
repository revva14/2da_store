<?php

namespace Database\Seeders;

use App\Models\Ulasan;
use Illuminate\Database\Seeder;

class UlasanSeeder extends Seeder
{
    /**
     * Memindahkan data ulasan yang sebelumnya statis di
     * testimoni.blade.php & admin/ulasan.blade.php ke tabel ulasans,
     * supaya kedua halaman membaca sumber data yang sama.
     */
    public function run(): void
    {
        if (Ulasan::count() > 0) {
            $this->command->info('Tabel ulasans sudah berisi data, seeding dilewati.');
            return;
        }

        $data = [
            [
                'nama' => 'Anisa Rahmawati', 'kategori' => 'corndog', 'rating' => 5,
                'komentar' => 'Corndog mini mozarellanya enak banget kejunya lumer mulur pas digigit! Pop Ice Chocolatenya juga segar manisnya pas, gak bikin eneg. Cocok banget buat cemilan sore santai. Pengemasannya juga rapi!',
                'foto' => 'images/ulasan/ulasan-1.jpg',
                'no_pesanan' => '#ORD-9821',
                'item_pesanan' => ['1x Corndog Mini Mozarella', '1x Pop Ice Chocolate'],
                'is_pinned' => true,
                'balasan' => 'Halo Kak Anisa! Terima kasih banyak atas ulasan hangat dan foto cantiknya. Senang sekali tahu Corndog Mini Mozarella dan Pop Ice Chocolate kami cocok di lidah Kakak. Ditunggu orderan berikutnya ya kak, salam hangat dari seluruh tim 2da Store! ✨',
                'balasan_at' => now()->subDays(10)->setTime(16, 10),
                'helpful_count' => 38,
                'created_at' => now()->subDays(10)->setTime(15, 42),
            ],
            [
                'nama' => 'Dimas Prasetyo', 'kategori' => 'goreng', 'rating' => 3,
                'komentar' => 'Rasa Tempura Jontornya pedas nampol gurih mantap! Cuma Tahu Crispynya waktu sampai agak kurang hangat jadi kerenyahannya sedikit berkurang. Mohon kemasannya ditutup lebih rapat lagi ya min.',
                'foto' => null,
                'no_pesanan' => '#ORD-9844',
                'item_pesanan' => ['1x Tempura Jontor', '1x Tahu Crispy'],
                'is_pinned' => false,
                'balasan' => null,
                'balasan_at' => null,
                'helpful_count' => 6,
                'created_at' => now()->subHours(2),
            ],
            [
                'nama' => 'Fauzan Syahrul', 'kategori' => 'roti', 'rating' => 5,
                'komentar' => 'Cireng isi mininya renyah gurih dan isiannya gak pelit. Roti maryam mininya juga lembut, wangi butter gurih manisnya pas banget. Selalu jadi cemilan favorit tiap kumpul bareng keluarga!',
                'foto' => 'images/ulasan/ulasan-3.jpg',
                'no_pesanan' => '#ORD-9799',
                'item_pesanan' => ['1x Roti Maryam Mini', '1x Cireng Isi Mini'],
                'is_pinned' => false,
                'balasan' => 'Wah terima kasih banyak Kak Fauzan! Senang sekali Roti Maryam Mini dan Cireng Isi Mini jadi cemilan favorit Kakak. Kami selalu menjaga kelezatan serta kerenyahan bahan fresh setiap hari! 🙏✨',
                'balasan_at' => now()->subDay()->setTime(20, 5),
                'helpful_count' => 12,
                'created_at' => now()->subDay()->setTime(19, 15),
            ],
            [
                'nama' => 'Rina Setyowati', 'kategori' => 'cireng', 'rating' => 5,
                'komentar' => 'Cirengnya digoreng garing, kulitnya renyah tapi bagian dalamnya tetap empuk. Isiannya melimpah dan bumbunya terasa. Paling enak dimakan selagi hangat. Selalu repeat order tiap Jumat.',
                'foto' => 'images/cireng.jpg',
                'no_pesanan' => null, 'item_pesanan' => ['2 Porsi Cireng Isi'],
                'is_pinned' => false, 'balasan' => null, 'balasan_at' => null,
                'helpful_count' => 52, 'created_at' => now()->subHours(3),
            ],
            [
                'nama' => 'Nabila Putri', 'kategori' => 'minuman', 'rating' => 5,
                'komentar' => 'Mojitonya segar banget! Ada pilihan rasa kuning, merah, biru, sampai oranye, warnanya cantik buat difoto. Manisnya pas dan dingin banget diminum siang hari. Cocok dipasangkan sama gorengan.',
                'foto' => 'images/mojito.jpg',
                'no_pesanan' => null, 'item_pesanan' => ['4 Gelas Mojito'],
                'is_pinned' => false, 'balasan' => null, 'balasan_at' => null,
                'helpful_count' => 44, 'created_at' => now()->subHours(5),
            ],
            [
                'nama' => 'Fajar Nugroho', 'kategori' => 'minuman', 'rating' => 4,
                'komentar' => 'Es coklat blendernya kental, rasa coklatnya kuat dan dinginnya pas. Ukuran gelasnya lumayan besar jadi puas. Semoga ke depannya ada pilihan level manis biar bisa disesuaikan.',
                'foto' => null,
                'no_pesanan' => null, 'item_pesanan' => ['3 Gelas Es Coklat'],
                'is_pinned' => false, 'balasan' => null, 'balasan_at' => null,
                'helpful_count' => 9, 'created_at' => now()->subDays(2),
            ],
            [
                'nama' => 'Sinta Maharani', 'kategori' => 'goreng', 'rating' => 4,
                'komentar' => 'Tahu crispy-nya potongannya kecil-kecil dan garing, bumbunya melimpah dan gurih. Cuma pedasnya kurang buat aku, tapi tetap enak dan porsinya banyak. Pas buat teman nonton.',
                'foto' => 'images/tahu.jpg',
                'no_pesanan' => null, 'item_pesanan' => ['2 Porsi Tahu Crispy'],
                'is_pinned' => false, 'balasan' => null, 'balasan_at' => null,
                'helpful_count' => 27, 'created_at' => now()->subDays(4),
            ],
        ];

        foreach ($data as $row) {
            // created_at bukan bagian dari $fillable, jadi diisi manual
            // setelah record dibuat supaya waktu ulasan lama tetap terjaga.
            $createdAt = $row['created_at'] ?? now();
            unset($row['created_at']);

            $ulasan = Ulasan::create($row);
            $ulasan->timestamps = false;
            $ulasan->created_at = $createdAt;
            $ulasan->updated_at = $createdAt;
            $ulasan->save();
        }

        $this->command->info(count($data) . ' ulasan berhasil di-seed ke tabel ulasans.');
    }
}