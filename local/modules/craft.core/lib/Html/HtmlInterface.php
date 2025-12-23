<?php

namespace Craft\Core\Html;

interface HtmlInterface
{
	public function beginForm(array $htmlOptions = []): string;

	public function endForm(): string;

	public function renderTag(string $tag, array $htmlOptions = []): string;

	public function beginTag(string $tag, array $htmlOptions = []): string;

	public function endTag(string $tag): string;

	public function renderHtmlOptions(array $htmlOptions): string;

	public function select(string $inputName, array $values, array $htmlOptions = []): string;

	public function textarea(array $htmlOptions = []): string;

	public function password(string $inputName, array $htmlOptions = []): string;

	public function input(string $inputName, array $htmlOptions = []): string;

	public function baseInput(string $inputName, string $type, array $htmlOptions = []): string;

}