<?php

namespace App;

use RiotAPI\Base\Definitions\Region;
use RiotAPI\DataDragonAPI\DataDragonAPI;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function boot(): void {
        DataDragonAPI::initByRegion(Region::EUROPE_WEST, [
            DataDragonAPI::SET_VERSION => '13.22.1'
        ]);

        parent::boot();
    }
}
