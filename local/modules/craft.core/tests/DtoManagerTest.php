<?php

use Craft\Core\Helper\DtoManager;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversMethod;


#[CoversMethod(DtoManager::class, 'testFromSnakeCaseToCamelCase')]
#[CoversMethod(DtoManager::class, 'transformKeyToUpper')]
#[CoversMethod(DtoManager::class, 'analyzeVariable')]
class DtoManagerTest extends TestCase
{
	protected DtoManager $manager;

	protected function setUp(): void
	{
		$this->manager = new DtoManager();
	}

	public function testTransformKey()
	{
		$this->assertSame(
			'KEY',
			$this->manager->transformKeyToUpper('key')
		);

		$this->assertSame(
			'SOME_VAR',
			$this->manager->transformKeyToUpper('some_var')
		);

		$this->assertSame(
			'SOME_VAR',
			$this->manager->transformKeyToUpper('someVar')
		);
	}


	public function testFromSnakeCaseToCamelCase()
	{
		$this->assertEquals(
			'someVar',
			$this->manager->fromSnakeCaseToCamelCase('some_var')
		);
	}

	public function testAnalyzeVariable()
	{
		$this->assertSame(
			DtoManager::TYPE_SNAKE_CASE,
			$this->manager->analyzeVariable('some_var')
		);


		$this->assertEquals(
			null,
			$this->manager->analyzeVariable('some')
		);
	}
}