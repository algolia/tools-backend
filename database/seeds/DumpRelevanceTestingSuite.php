<?php

use App\Models\RelevanceTesting\Group;
use App\Models\RelevanceTesting\Run;
use App\Models\RelevanceTesting\Test;
use App\Models\RelevanceTesting\Suite;
use Illuminate\Database\Seeder;

class DumpRelevanceTestingSuite extends Seeder
{
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__.'/data/dumbSuite.json'));

        foreach ($data as $s) {
            $suite = new Suite();
            $suite->name = $s->name;
            $suite->user_id = 5995;

            $suite->save();

            foreach ($s->groups as $g) {
                $group = new Group();
                $group->name = $g->name;
                $group->suite_id = $suite->id;
                $group->save();

                foreach ($g->tests as $t) {
                    $test = new Test();
                    $test->group_id = $group->id;
                    $test->test_data = json_encode($t);
                    $test->save();
                }
            }

            foreach ($s->runs as $r) {
                $run = new Run();
                $run->suite_id = $suite->id;
                $run->app_id = $r->appId;
                $run->index_name = $r->indexName;
                $run->hits_per_page = $r->hitsPerPage;
                $run->params = json_encode($r->params);
                $run->save();
            }
        }
    }
}
