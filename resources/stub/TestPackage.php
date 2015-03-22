<?php

# place wherever, make sure its get autoloaded,

namespace Laradic\Tests\Docs;

use Illuminate\Foundation\Application;
use Laradic\Docs\Github\GithubProjectSynchronizer;
use Laradic\Dev\AbstractTestPackage;

class TestPackage extends AbstractTestPackage
{
    public function XtestGithubBranches()
    {
        $project = 'config';
        $gps = $this->app->make('Laradic\Docs\Github\GithubProjectSynchronizer');
        $branches = $gps->getUnsyncedBranches($project);
        foreach($branches as $branch)
        {
            $gps->syncBranch($project, $branch);
        }
    }


    public function testGithubBranchesAndTags()
    {
        $project = 'docs-test';
        /** @var \Laradic\Docs\Github\GithubProjectSynchronizer $gps */
        $gps = $this->app->make('Laradic\Docs\Github\GithubProjectSynchronizer');
        $tags = $gps->getUnsyncedTags($project);

        foreach($tags as $tag)
        {
            $gps->syncTag($project, $tag);
        }

        $branches = $gps->getUnsyncedBranches($project);
        foreach($branches as $branch)
        {
            $gps->syncBranch($project, $branch);
        }

        $entries = $gps->getLogEntries();

        return $entries;

    }




}
