<?php

namespace Hyvor\Internal\Laravel\Database\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DatabaseNukeCommand extends Command
{

    public $signature = 'internal:db:nuke';
    public $description = 'Deletes the current schema and recreates it. Only works with PostgreSQL.';

    public function handle(): void
    {
        $this->info('Dropping schema...');

        DB::unprepared('
            DROP SCHEMA public CASCADE;
            CREATE SCHEMA public;
            GRANT ALL ON SCHEMA public TO public;
        ');

        $this->info('Done!');
    }

}