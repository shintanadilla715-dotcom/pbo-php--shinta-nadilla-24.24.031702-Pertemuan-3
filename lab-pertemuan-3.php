<?php
// LAB 3 — Enkapsulasi
// Spesifikasi:
//  - Rekening(string $nomor, string $pemilik), properti PRIVATE $saldo = 0
//      setor(float $jumlah): bool   -> false jika jumlah <= 0
//      tarik(float $jumlah): bool   -> false jika jumlah > saldo
//      transfer(Rekening $tujuan, float $jumlah): bool
//      getSaldo(): float, getRiwayat(): array
//  - Siswa() dengan setNilai(int) (hanya 0–100) dan getNilai(): int

class Rekening
{
   private string $nomor;
    private string $pemilik;
    private float $saldo = 0;
    private array $riwayat = [];
    
    public function __construct(string $nomor, string $pemilik)
    {
        $this->nomor = $nomor;
        $this->pemilik = $pemilik;
    }
    
    public function setor(float $jumlah): bool
    {
        if ($jumlah <=0) {
            return false;
        }
        $this->saldo += $jumlah;
        $this->riwayat[] = "setor: +{$jumlah} (saldo: {$this->saldo})";
        return true;
    }
    
    public function tarik(float $jumlah): bool
    {
        if ($jumlah <= 0 || $jumlah >$this->saldo) {
            return false;
        }
        $this->saldo -= $jumlah;
        $this->riwayat[] = "tarik: -{$jumlah} (saldo: {$this->saldo})";
        return true;
        }
    public function transfer(Rekening $tujuan, float $jumlah): bool
    {
        if ($jumlah <= 0 || $jumlah > $this->saldo) {
            return false;
        }
        $this->saldo -= $jumlah;
        $this->riwayat[] = "Transfer ke {$tujuan->nomor}: -{$jumlah} (Saldo: {$this->saldo})";

        $tujuan->saldo += $jumlah;
        $tujuan->riwayat[] = "Terima transfer dari {$this->nomor}: +{$jumlah} (Saldo: {$tujuan->saldo})";
        return true;
    }

    public function getSaldo(): float
    {
        return $this->saldo;
    }

    public function getRiwayat(): array
    {
        return $this->riwayat;
    }
}

class Siswa
{
    private string $nama = '';
    private int $nilai = 0;

    public function __construct(string $nama = '', int $nilai = 0)
    {
        $this->setNama($nama);
        $this->setNilai($nilai);
    }

    public function setNama(string $nama): bool
    {
        $trimmed = trim($nama);
        if ($trimmed === '') {
            return false;
        }
        $this->nama = $trimmed;
        return true;
    }

    public function getNama(): string
    {
        return $this->nama;
    }

    public function setNilai(int $nilai): bool
    {
        if ($nilai < 0 || $nilai > 100) {
            return false;
        }
        $this->nilai = $nilai;
        return true;
    }

    public function getNilai(): int
    {
        return $this->nilai;
    }
}

// --- CONTOH PENGUJIAN REKENING ---
$rek1 = new Rekening("101", "Budi");
$rek2 = new Rekening("102", "Siti");

$rek1->setor(500000);
$rek1->tarik(100000);
$rek1->transfer($rek2, 150000);

// Coba input tidak valid (harus mengembalikan false)
var_dump($rek1->setor(-5000));   // bool(false)
var_dump($rek1->tarik(999999));  // bool(false)

echo "Saldo Rek 1: " . $rek1->getSaldo() . "\n";
echo "Saldo Rek 2: " . $rek2->getSaldo() . "\n";

echo "Riwayat Rek 1:\n";
foreach ($rek1->getRiwayat() as $item) {
    echo "- " . $item . "\n";
}

echo "\n--- CONTOH PENGUJIAN SISWA ---\n";
$siswa1 = new Siswa("Andi", 88);
var_dump($siswa1->setNama("   ")); // bool(false) - nama kosong ditolak
var_dump($siswa1->setNilai(120));  // bool(false) - nilai > 100 ditolak

echo "Nama Siswa: " . $siswa1->getNama() . "\n";
echo "Nilai Siswa: " . $siswa1->getNilai() . "\n";





