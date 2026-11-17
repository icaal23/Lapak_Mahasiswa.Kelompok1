<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanPendapatanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Layout memakai @vite; di test tidak perlu build asset
        $this->withoutVite();
    }

    private function buatUser(string $nim = 'D0123456'): User
    {
        return User::factory()->create([
            'nim' => $nim,
            'program_studi' => 'Informatika',
        ]);
    }

    private function buatBarang(User $user, array $atribut = []): Barang
    {
        return Barang::create($atribut + [
            'user_id' => $user->id,
            'nama' => 'Barang Contoh',
            'kategori' => 'Buku',
            'harga' => 50000,
            'kondisi' => 'Bekas-Baik',
            'lokasi' => 'Kampus',
            'status' => 'aktif',
        ]);
    }

    public function test_tamu_diarahkan_ke_halaman_login(): void
    {
        $this->get(route('laporan.index'))->assertRedirect(route('login'));
    }

    public function test_laporan_menghitung_ringkasan_milik_sendiri_saja(): void
    {
        $user = $this->buatUser();
        $lain = $this->buatUser('D0999999');

        $hariIni = now()->toDateString();

        $this->buatBarang($user, ['nama' => 'Setrika Portable', 'kategori' => 'Elektronik', 'status' => 'terjual',
            'nama_pembeli' => 'Muhammad Faisal', 'harga_jual' => 90000, 'terjual_pada' => $hariIni]);
        $this->buatBarang($user, ['nama' => 'Modul Praktikum', 'kategori' => 'Buku', 'status' => 'terjual',
            'nama_pembeli' => 'Zaskia', 'harga_jual' => 35000, 'terjual_pada' => $hariIni]);
        $this->buatBarang($user, ['nama' => 'Kalkulator', 'kategori' => 'Perlengkapan Kuliah', 'status' => 'terjual',
            'nama_pembeli' => 'Andi', 'harga_jual' => 80000, 'terjual_pada' => $hariIni]);
        $this->buatBarang($user, ['nama' => 'Laptop Lenovo']);
        $this->buatBarang($user, ['nama' => 'Tas Ransel']);

        // Milik user lain tidak boleh ikut terhitung
        $this->buatBarang($lain, ['nama' => 'Barang Orang Lain', 'status' => 'terjual',
            'nama_pembeli' => 'X', 'harga_jual' => 999000, 'terjual_pada' => $hariIni]);

        $response = $this->actingAs($user)->get(route('laporan.index'));

        $response->assertOk()
            ->assertSee('Laporan pendapatan')
            ->assertSee('Setrika Portable')
            ->assertDontSee('Barang Orang Lain')
            ->assertViewHas('totalPendapatan', 205000)
            ->assertViewHas('jumlahTerjual', 3)
            ->assertViewHas('terjualBulanIni', 3)
            ->assertViewHas('barangAktif', 2)
            ->assertViewHas('rataRata', 68333);
    }

    public function test_laporan_kosong_tidak_error(): void
    {
        $user = $this->buatUser();

        $this->actingAs($user)->get(route('laporan.index'))
            ->assertOk()
            ->assertSee('Belum ada penjualan')
            ->assertViewHas('totalPendapatan', 0)
            ->assertViewHas('rataRata', 0);
    }

    public function test_pemilik_bisa_menandai_barang_aktif_sebagai_terjual(): void
    {
        $user = $this->buatUser();
        $barang = $this->buatBarang($user);

        $this->actingAs($user)->get(route('barang.terjual.create', $barang))->assertOk();

        $this->actingAs($user)->post(route('barang.terjual.store', $barang), [
            'nama_pembeli' => 'Zaskia',
            'harga_jual' => 'Rp.45.000',
            'terjual_pada' => now()->toDateString(),
        ])->assertRedirect(route('laporan.index'));

        $barang->refresh();
        $this->assertSame('terjual', $barang->status);
        $this->assertSame('Zaskia', $barang->nama_pembeli);
        $this->assertSame(45000, $barang->harga_jual);
    }

    public function test_tidak_bisa_menandai_barang_orang_lain_atau_yang_belum_aktif(): void
    {
        $user = $this->buatUser();
        $lain = $this->buatUser('D0999999');

        $milikLain = $this->buatBarang($lain);
        $masihDraft = $this->buatBarang($user, ['status' => 'draft']);

        $this->actingAs($user)->get(route('barang.terjual.create', $milikLain))->assertForbidden();
        $this->actingAs($user)->get(route('barang.terjual.create', $masihDraft))->assertForbidden();
        $this->actingAs($user)->post(route('barang.terjual.store', $masihDraft), [
            'nama_pembeli' => 'A', 'harga_jual' => '1000', 'terjual_pada' => now()->toDateString(),
        ])->assertForbidden();
    }

    public function test_validasi_form_tandai_terjual(): void
    {
        $user = $this->buatUser();
        $barang = $this->buatBarang($user);

        $this->actingAs($user)->post(route('barang.terjual.store', $barang), [])
            ->assertSessionHasErrors(['nama_pembeli', 'harga_jual', 'terjual_pada']);

        $this->assertSame('aktif', $barang->fresh()->status);
    }
}
