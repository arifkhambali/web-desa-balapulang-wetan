<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AparaturDesa;
use Carbon\Carbon;

class AparaturDesaSeeder extends Seeder
{
    public function run()
    {
        $aparaturData = [
            // Kepala Desa
            [
                'nama' => 'Budi Santoso, S.Sos',
                'nip' => '197503121998031001',
                'jabatan' => 'Kepala Desa',
                'urutan' => 1,
                'email' => 'kepala.desa@desamajujaya.id',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Raya Desa Tundagan No. 1, Kec. Sejahtera',
                'tanggal_mulai_jabatan' => Carbon::parse('2019-08-17'),
                'tanggal_selesai_jabatan' => Carbon::parse('2025-08-17'),
                'aktif' => true,
            ],
            
            // Sekretaris Desa
            [
                'nama' => 'Siti Nurhaliza, S.AP',
                'nip' => '198205102005022001',
                'jabatan' => 'Sekretaris Desa',
                'urutan' => 2,
                'email' => 'sekretaris@desamajujaya.id',
                'telepon' => '081234567891',
                'alamat' => 'Jl. Mawar No. 15, Desa Tundagan',
                'tanggal_mulai_jabatan' => Carbon::parse('2005-01-15'),
                'tanggal_selesai_jabatan' => null,
                'aktif' => true,
            ],
            
            // Kaur Keuangan
            [
                'nama' => 'Ahmad Fauzi, S.E',
                'nip' => '198709152010011002',
                'jabatan' => 'Kaur Keuangan',
                'urutan' => 3,
                'email' => 'keuangan@desamajujaya.id',
                'telepon' => '081234567892',
                'alamat' => 'Jl. Melati No. 8, Desa Tundagan',
                'tanggal_mulai_jabatan' => Carbon::parse('2010-03-01'),
                'tanggal_selesai_jabatan' => null,
                'aktif' => true,
            ],
            
            // Kaur Perencanaan
            [
                'nama' => 'Dewi Lestari, S.T',
                'nip' => '199001202015022001',
                'jabatan' => 'Kaur Perencanaan',
                'urutan' => 4,
                'email' => 'perencanaan@desamajujaya.id',
                'telepon' => '081234567893',
                'alamat' => 'Jl. Anggrek No. 12, Desa Tundagan',
                'tanggal_mulai_jabatan' => Carbon::parse('2015-06-01'),
                'tanggal_selesai_jabatan' => null,
                'aktif' => true,
            ],
            
            // Kaur Tata Usaha dan Umum
            [
                'nama' => 'Rina Wijaya, S.Sos',
                'nip' => '198803252012022001',
                'jabatan' => 'Kaur Tata Usaha dan Umum',
                'urutan' => 5,
                'email' => 'tata.usaha@desamajujaya.id',
                'telepon' => '081234567894',
                'alamat' => 'Jl. Kenanga No. 20, Desa Tundagan',
                'tanggal_mulai_jabatan' => Carbon::parse('2012-09-01'),
                'tanggal_selesai_jabatan' => null,
                'aktif' => true,
            ],
            
            // Kasi Pemerintahan
            [
                'nama' => 'Joko Widodo, S.IP',
                'nip' => '198506102008011001',
                'jabatan' => 'Kasi Pemerintahan',
                'urutan' => 6,
                'email' => 'pemerintahan@desamajujaya.id',
                'telepon' => '081234567895',
                'alamat' => 'Jl. Dahlia No. 5, Desa Tundagan',
                'tanggal_mulai_jabatan' => Carbon::parse('2008-04-01'),
                'tanggal_selesai_jabatan' => null,
                'aktif' => true,
            ],
            
            // Kasi Kesejahteraan
            [
                'nama' => 'Ani Suryani, S.Sos',
                'nip' => '199102152016022001',
                'jabatan' => 'Kasi Kesejahteraan',
                'urutan' => 7,
                'email' => 'kesejahteraan@desamajujaya.id',
                'telepon' => '081234567896',
                'alamat' => 'Jl. Flamboyan No. 18, Desa Tundagan',
                'tanggal_mulai_jabatan' => Carbon::parse('2016-02-01'),
                'tanggal_selesai_jabatan' => null,
                'aktif' => true,
            ],
            
            // Kasi Pelayanan
            [
                'nama' => 'Hendra Gunawan, S.Kom',
                'nip' => '198912202014011001',
                'jabatan' => 'Kasi Pelayanan',
                'urutan' => 8,
                'email' => 'pelayanan@desamajujaya.id',
                'telepon' => '081234567897',
                'alamat' => 'Jl. Cempaka No. 22, Desa Tundagan',
                'tanggal_mulai_jabatan' => Carbon::parse('2014-07-01'),
                'tanggal_selesai_jabatan' => null,
                'aktif' => true,
            ],
            
            // Kepala Dusun I
            [
                'nama' => 'Bambang Prasetyo',
                'nip' => null,
                'jabatan' => 'Kepala Dusun I',
                'urutan' => 9,
                'email' => null,
                'telepon' => '081234567898',
                'alamat' => 'Dusun I, Desa Tundagan',
                'tanggal_mulai_jabatan' => Carbon::parse('2018-01-01'),
                'tanggal_selesai_jabatan' => null,
                'aktif' => true,
            ],
            
            // Kepala Dusun II
            [
                'nama' => 'Suryanto',
                'nip' => null,
                'jabatan' => 'Kepala Dusun II',
                'urutan' => 10,
                'email' => null,
                'telepon' => '081234567899',
                'alamat' => 'Dusun II, Desa Tundagan',
                'tanggal_mulai_jabatan' => Carbon::parse('2018-01-01'),
                'tanggal_selesai_jabatan' => null,
                'aktif' => true,
            ],
            
            // Kepala Dusun III
            [
                'nama' => 'Agus Salim',
                'nip' => null,
                'jabatan' => 'Kepala Dusun III',
                'urutan' => 11,
                'email' => null,
                'telepon' => '081234567800',
                'alamat' => 'Dusun III, Desa Tundagan',
                'tanggal_mulai_jabatan' => Carbon::parse('2018-01-01'),
                'tanggal_selesai_jabatan' => null,
                'aktif' => true,
            ],
        ];

        foreach ($aparaturData as $data) {
            AparaturDesa::create($data);
        }
    }
}
