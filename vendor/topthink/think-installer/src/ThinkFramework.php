<?php

namespace think\composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Repository\InstalledRepositoryInterface;

class ThinkFramework extends LibraryInstaller
{
    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        if ('topthink/framework' !== $package->getPrettyName()) {
            throw new \InvalidArgumentException('Unable to install this library!');
        }

        if ($this->composer->getPackage()->getType() !== 'project') {
            return parent::getInstallPath($package);
        }

        if ($this->composer->getPackage()) {
            $extra = $this->composer->getPackage()->getExtra();
            if (!empty($extra['think-path'])) {
                return $extra['think-path'];
            }
        }

        return 'thinkphp';
    }

    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);
        if ($this->composer->getPackage()->getType() == 'project') {
            //remove tests dir
            $this->filesystem->removeDirectory($this->getInstallPath($package) . DIRECTORY_SEPARATOR . 'tests');
        }
    }

    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        parent::update($repo, $initial, $target);
        if ($this->composer->getPackage()->getType() == 'project') {
            //remove tests dir
            $this->filesystem->removeDirectory($this->getInstallPath($target) . DIRECTORY_SEPARATOR . 'tests');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'think-framework' === $packageType;
    }
}