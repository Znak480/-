<?php

namespace Craft\Service\CallTouch;

interface CallTouchInterface
{
	public function send(array $params = []): void;
}