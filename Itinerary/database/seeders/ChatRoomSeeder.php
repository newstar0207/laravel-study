<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChatRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function rand_color()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    public function run()
    {
        DB::table('chat_rooms')->insert([
            'title' => Str::random(7),
            'owner' => 'newstar0207',
            'room_color' => $this->rand_color(),
        ]);
    }
}
