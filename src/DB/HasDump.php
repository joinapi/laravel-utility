<?php

namespace Joinapi\Utility\DB;

use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;

trait HasDump
{
    public function withProgressBar(int $amount, ?Closure $createCollectionOfOne, bool $raw = false): Collection
    {

        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection;

        if (! $raw) {
            $items = new Collection;

            foreach (range(1, $amount) as $i) {
                $items = $items->merge(
                    $createCollectionOfOne()
                );
                $progressBar->advance();
            }
        } else {
            $createCollectionOfOne();
            $items->add(1);
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }

    protected function execute_sql(string $path): mixed
    {
        $sql = base_path($path);
        DB::unprepared(file_get_contents($sql));

        return [1];
    }
}
