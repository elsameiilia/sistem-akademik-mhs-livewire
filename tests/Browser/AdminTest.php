<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $seeder = \Database\Seeders\DuskTestingSeeder::class;
    /**
     * Test login sebagai admin & akses dashboard.
     */
    public function test_admin_can_login_and_access_dashboard(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'admin@test.com')
                ->type('password', 'password')
                ->click('button[type="submit"]')
                ->waitForLocation('/dashboard', 5)
                ->assertSee('Selamat Datang');
        });
    }

    /**
     * Test CRUD Prodi.
     */
    public function test_admin_can_crud_prodi(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1) 
                ->visit('/prodi')
                ->assertSee('Daftar Prodi')
                ->assertSee('Informatika') 

                // UPDATE 
                ->click('@edit-prodi-1')
                ->waitForLocation('/prodi/1/edit', 5)
                ->assertSee('Edit Prodi')
                ->clear('@nama_prodi')
                ->type('@nama_prodi', 'Informatika Updated')
                ->pause(500)
                ->scrollIntoView('@btn-update-prodi')
                ->click('@btn-update-prodi')
                ->waitForLocation('/prodi', 5)
                ->assertSee('Data berhasil diperbarui') 
                ->assertSee('Informatika Updated');

            // CREATE 
            $browser->click('@btn-add-prodi')
                ->waitForLocation('/prodi/create', 5)
                ->assertSee('Tambah Prodi Baru')
                ->type('@nama_prodi', 'Teknik Komputer')
                ->select('@fakultas_id', '1')
                ->pause(500)
                ->scrollIntoView('@btn-submit-prodi')
                ->click('@btn-submit-prodi')
                ->waitForLocation('/prodi', 5)
                ->assertSee('Data prodi berhasil ditambahkan')
                ->assertSee('Teknik Komputer');

            // DELETE
            $browser->click('@delete-prodi-1')
                ->waitForDialog(5)
                ->acceptDialog()
                ->pause(1000) 
                ->assertDontSee('Informatika Updated');
        });
    }

    /**
     * CRUD Mata Kuliah.
     */
    public function test_admin_can_crud_matakuliah(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/mata-kuliah')
                ->assertSee('Daftar Mata Kuliah')
                ->assertSee('UKPL'); 

            // UPDATE
            $browser->click('@edit-mk-1')
                ->waitForLocation('/mata-kuliah/1/edit', 5)
                ->assertSee('Edit Mata Kuliah')
                ->clear('@nama_matakuliah')
                ->type('@nama_matakuliah', 'UKPL Updated')
                ->pause(500)
                ->scrollIntoView('@btn-update-mk')
                ->click('@btn-update-mk')
                ->waitForLocation('/mata-kuliah', 5)
                ->assertSee('Data berhasil diperbarui')
                ->assertSee('UKPL Updated');

            // CREATE 
            $browser->click('@btn-add-mk')
                ->waitForLocation('/mata-kuliah/create', 5)
                ->assertSee('Tambah Mata Kuliah Baru')
                ->type('@kode', 'IF999')
                ->type('@nama_matakuliah', 'Testing Dusk')
                ->type('@sks', '2')
                ->pause(1000)
                ->scrollIntoView('@btn-submit-mk')
                ->pause(500)
                ->click('@btn-submit-mk')
                ->pause(2000)
                ->waitForLocation('/mata-kuliah', 5)
                ->assertSee('Data mata kuliah berhasil ditambahkan')
                ->assertSee('Testing Dusk');

            // DELETE
            $browser->click('@delete-mk-1')
                ->waitForDialog(5)
                ->acceptDialog()
                ->pause(1000)
                ->assertDontSee('UKPL Updated');
        });
    }

    /**
     * CRUD Mahasiswa.
     */
    public function test_admin_can_crud_mahasiswa(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/mahasiswa')
                ->assertSee('Daftar Mahasiswa')
                ->assertSee('Mahasiswa Testing'); 

            // UPDATE 
            $browser->click('@edit-mhs-1')
                ->waitForLocation('/mahasiswa/1/edit', 5)
                ->assertSee('Edit Data Mahasiswa')
                ->clear('@nama')
                ->type('@nama', 'Mahasiswa Testing Edited')
                ->pause(500)
                ->scrollIntoView('@btn-update-mhs')
                ->click('@btn-update-mhs')
                ->waitForLocation('/mahasiswa', 5)
                ->assertSee('Data berhasil diperbarui') 
                ->assertSee('Mahasiswa Testing Edited');

            // CREATE 
            $browser->click('@btn-add-mhs')
                ->waitForLocation('/mahasiswa/create', 5)
                ->assertSee('Tambah Mahasiswa Baru')
                ->type('@nim', '2023999')
                ->type('@nama', 'Mahasiswa Dusk')
                ->select('@prodi_id', '1')
                ->pause(500)
                ->scrollIntoView('@btn-submit-mhs')
                ->click('@btn-submit-mhs')
                ->waitForLocation('/mahasiswa', 5)
                ->assertSee('Data mahasiswa berhasil ditambahkan')
                ->assertSee('Mahasiswa Dusk');

            // DELETE
            $browser->click('@delete-mhs-1')
                ->waitForDialog(5)
                ->acceptDialog()
                ->pause(1000)
                ->assertDontSee('Mahasiswa Testing Edited');
        });
    }
}
