<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisi', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 250)->nullable();
            $table->timestamps();
        });

        Schema::create('absen', function (Blueprint $table) {
            $table->id();
            $table->integer('id_permohonan_rapat');
            $table->string('nama', 250);
            $table->string('divisi', 250);
            $table->string('jabatan', 250);
            $table->integer('hari');
            $table->timestamps();
        });

        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 250);
            $table->string('nama_ruangan', 250);
            $table->string('nama_rapat', 250);
            $table->dateTime('waktu_mulai');
            $table->timestamps();
        });



        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 250);
            $table->string('kondisi', 250);
            $table->timestamps();
        });


        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->integer('no_induk');
            $table->string('nama', 250);
            $table->string('divisi', 250);
            $table->string('jabatan', 250);
            $table->string('lampiran', 250);
            $table->timestamps();
        });

        Schema::create('permohonan_rapat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rapat', 250);
            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar');
            $table->string('deskripsi_rapat', 250);
            $table->integer('jumlah_peserta');
            $table->integer('id_ruangrapat');
            $table->integer('id_pegawai');
            $table->integer('id_fasilitas');
            $table->string('notulen');
            $table->integer('status');
            $table->string('catatan', 250);
            $table->string('kode_absen', 250);
            $table->timestamps();
        });

        Schema::create('ruangrapat', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 250);
            $table->integer('kapasitas');
            $table->integer('pegawai_id');
            $table->string('lokasi', 250);
            $table->integer('status');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('divisi');
    }
}
