<?php

/** @phpstan-ignore-next-line */
$commandLine = $this->commandLine();
$commandLine->option('ff', 'default', 1);
$commandLine->option('src', 'default', 'app');
$commandLine->option('spec', 'default', 'app');
$commandLine->option('no-header', 'default', true);
