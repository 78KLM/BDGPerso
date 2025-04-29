<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

// Le Kernel est le cœur de l'application Symfony, responsable de la gestion des bundles et de la configuration.
class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
