<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Data_Pelatih;
use App\Juklak_Ujian;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $user = [
            '1' => ['status' => 'bestnimda', 'name' => 'Tio Rizky Bachtiar', 'slug_name' => 'tio_rizky_bachtiar', 'email' => 'bachtiar@mail.com', 'password' => '$2y$10$2FVnpQ5LQNm5PEPj4o.js.QXVAhSX0R8f7MR/iguaviefBKbVFweC', 'born' => '1996-03-24', 'phone' => NULL, 'id_line' => NULL, 'avatar' => '/photos/1/thebachtiarz.png', 'code' => '97wzIGYkktZh1IXpNNRPojMsOOoLNwE797wzIGYkktZh1IXpNNRPojMsOOoLNwE7', 'created_at' => '2019-07-02 08:41:31', 'updated_at' => '2019-07-15 08:52:06'],
            '2' => ['status' => 'moderator', 'name' => 'Edo Satria Nata', 'slug_name' => 'edo_satria_nata', 'email' => 'edosatria@mail.com', 'password' => '$2y$10$PZiKIaA2HSWZvyecJkb3mO24QPzV6WZpD3lK8sgqynABBN9X/cRr.', 'born' => NULL, 'phone' => NULL, 'id_line' => NULL, 'avatar' => NULL, 'code' => 'hflosqySM6fZ0NCCTBDrSpHic2rL5u8hhflosqySM6fZ0NCCTBDrSpHic2rL5u8h', 'created_at' => '2019-07-15 00:34:26', 'updated_at' => '2019-07-15 00:34:26'],
            '3' => ['status' => 'moderator', 'name' => 'Saptiani Novirda', 'slug_name' => 'saptiani_novirda', 'email' => 'saptiani@mail.com', 'password' => '$2y$10$yhE9u.q7nlSgMGqwYGA/GOAOkYXMPgAs5bAOQaPobIfdrRJhCDEQy', 'born' => '1998-06-16', 'phone' => '085122657512', 'id_line' => 'novirdaseptiani98', 'avatar' => '/photos/4/112976_e.jpg', 'code' => 'T82znslzBDhJZODaIuU6SoCV6xWN4hywT82znslzBDhJZODaIuU6SoCV6xWN4hyw', 'created_at' => '2019-07-15 04:19:21', 'updated_at' => '2019-07-27 22:35:52']
        ];

        $pltdt = [
            '1' => ['kode_pelatih' => '97wzIGYkktZh1IXpNNRPojMsOOoLNwE797wzIGYkktZh1IXpNNRPojMsOOoLNwE7', 'nama_pelatih' => 'Tio Rizky Bachtiar', 'msh_pelatih' => '17985', 'created_at' => '2019-07-15 08:52:06', 'updated_at' => '2019-07-15 08:52:06'],
            '2' => ['kode_pelatih' => 'hflosqySM6fZ0NCCTBDrSpHic2rL5u8hhflosqySM6fZ0NCCTBDrSpHic2rL5u8h', 'nama_pelatih' => 'Edo Satria Nata', 'msh_pelatih' => NULL, 'created_at' => '2019-07-15 00:36:00', 'updated_at' => '2019-07-15 00:36:00'],
            '3' => ['kode_pelatih' => 'T82znslzBDhJZODaIuU6SoCV6xWN4hywT82znslzBDhJZODaIuU6SoCV6xWN4hyw', 'nama_pelatih' => 'Saptiani Novirda', 'msh_pelatih' => '18346', 'created_at' => '2019-07-15 04:25:01', 'updated_at' => '2019-07-27 22:35:52'],
        ];

        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'status' => $user[$i]['status'],
                'name' => $user[$i]['name'],
                'slug_name' => $user[$i]['slug_name'],
                'email' => $user[$i]['email'],
                'password' => $user[$i]['password'],
                'born' => $user[$i]['born'],
                'phone' => $user[$i]['phone'],
                'id_line' => $user[$i]['id_line'],
                'avatar' => $user[$i]['avatar'],
                'code' => $user[$i]['code'],
                'created_at' => $user[$i]['created_at'],
                'updated_at' => $user[$i]['updated_at']
            ]);
            Data_Pelatih::create([
                'kode_pelatih' => $pltdt[$i]['kode_pelatih'],
                'nama_pelatih' => $pltdt[$i]['nama_pelatih'],
                'msh_pelatih' => $pltdt[$i]['msh_pelatih'],
                'created_at' => $pltdt[$i]['created_at'],
                'updated_at' => $pltdt[$i]['updated_at']
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            if ($i != 9) {
                Juklak_Ujian::create([
                    'auth_kyu' => (string) $i,
                    'file_name' => 'materi_juklak_kyu_' . (string) $i . '',
                    'file_url' => 'materi_juklak_kyu_' . (string) $i . '.pdf'
                ]);
            }
        }

        # test bayar spp
        // for ($i = 6; $i <= 8; $i++) {
        //     Record_Spp::create([
        //         'thsmt' => '192001',
        //         'kode_kelas' => 'MLeQ8DKwzp',
        //         'kode_peserta' => '5ZOYwPhUVojnc9MnIvz4breR9jgMcKBJt0sNCrfjKBNXp9uOOo6ZGxzpNNI4rrjc',
        //         'kredit' => '20000',
        //         'untuk_bulan' => (string) $i,
        //         'kode_pj' => 'T82znslzBDhJZODaIuU6SoCV6xWN4hywT82znslzBDhJZODaIuU6SoCV6xWN4hyw'
        //     ]);
        // }


        // +----+--------------+--------------------+--------------------+-------------------+--------------------------------------------------------------+------------+--------------+-------------------+----------------------------+----------------------------------+--------------------------------------------------------------+---------------------+---------------------+
        // | id | status       | name               | email              | email_verified_at | password                                                     | born       | phone        | id_line           | avatar                     | code                             | remember_token                                               | created_at          | updated_at          |
        // +----+--------------+--------------------+--------------------+-------------------+--------------------------------------------------------------+------------+--------------+-------------------+----------------------------+----------------------------------+--------------------------------------------------------------+---------------------+---------------------+
        // |  1 | bestnimda    | Tio Rizky Bachtiar | bachtiar@mail.com  | NULL              | $2y$10$2FVnpQ5LQNm5PEPj4o.js.QXVAhSX0R8f7MR/iguaviefBKbVFweC | 1996-03-24 | NULL         | NULL              | /photos/1/thebachtiarz.png | 97wzIGYkktZh1IXpNNRPojMsOOoLNwE7 | 2uXVqJs0eK82LPN2MrgqtScAc0ukHNHutq1BfbNrKl44pDwV4KPsF7lczb43 | 2019-07-02 08:41:31 | 2019-07-15 08:52:06 |
        // |  2 | moderator    | Edo Satria Nata    | edosatria@mail.com | NULL              | $2y$10$PZiKIaA2HSWZvyecJkb3mO24QPzV6WZpD3lK8sgqynABBN9X/cRr. | NULL       | NULL         | NULL              | NULL                       | hflosqySM6fZ0NCCTBDrSpHic2rL5u8h | NULL                                                         | 2019-07-15 00:34:26 | 2019-07-15 00:34:26 |
        // |  3 | moderator    | Saptiani Novirda   | saptiani@mail.com  | NULL              | $2y$10$yhE9u.q7nlSgMGqwYGA/GOAOkYXMPgAs5bAOQaPobIfdrRJhCDEQy | 1998-06-16 | 085122657512 | novirdaseptiani98 | /photos/4/112976_e.jpg     | T82znslzBDhJZODaIuU6SoCV6xWN4hyw | NULL                                                         | 2019-07-15 04:19:21 | 2019-07-27 22:35:52 |
        // +----+--------------+--------------------+--------------------+-------------------+--------------------------------------------------------------+------------+--------------+-------------------+----------------------------+----------------------------------+--------------------------------------------------------------+---------------------+---------------------+


        // +----+----------------------------------+------------------+-------------+---------------------+---------------------+
        // | id | kode_pelatih                     | nama_pelatih     | msh_pelatih | created_at          | updated_at          |
        // +----+----------------------------------+------------------+-------------+---------------------+---------------------+
        // |  1 | hflosqySM6fZ0NCCTBDrSpHic2rL5u8h | Edo Satria Nata  | NULL        | 2019-07-15 00:36:00 | 2019-07-15 00:36:00 |
        // |  2 | T82znslzBDhJZODaIuU6SoCV6xWN4hyw | Saptiani Novirda | 18346       | 2019-07-15 04:25:01 | 2019-07-27 22:35:52 |
        // +----+----------------------------------+------------------+-------------+---------------------+---------------------+

    }
}
