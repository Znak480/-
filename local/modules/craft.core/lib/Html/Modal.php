<?php

namespace Craft\Core\Html;

class Modal
{

	private ?string $title = null;
	private ?string $headerContent = null;
	private ?string $bodyContent = null;
	private ?string $footerContent = null;

	private ?string $closeContent = null;

	/**
	 * @return static
	 */
	public static function build(): Modal
	{
		return new static();
	}

	public function title(string $title): Modal
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * @param callable|string $content
	 */
	public function closeIcon($content): Modal
	{
		$this->closeContent = $this->extractContent($content);
		return $this;
	}

	/**
	 * @param callable|string $content
	 */
	public function header($content): Modal
	{
		$this->headerContent = $this->extractContent($content);
		return $this;
	}

	/**
	 * @param callable|string $content
	 */
	public function body($content): Modal
	{
		$this->bodyContent = $this->extractContent($content);
		return $this;
	}

	/**
	 * @param callable|string $content
	 */
	public function footer($content): Modal
	{
		$this->footerContent = $this->extractContent($content);
		return $this;
	}

	/**
	 * @param callable|string $content
	 */
	protected function extractContent($content)
	{
		if(is_callable($content))
		{
			$content = $content();
		}

		return $content;
	}

	public function show(): string
	{
		ob_start();
		?>
		<div class="site-modal">

			<?php
			if($this->closeContent)
			{
				?>
				<div class="site-modal-close" data-fancybox-close><?=$this->closeContent;?></div>
				<?php
			}
			?>

			<?php
			if($this->headerContent || $this->title)
			{
				?>
				<div class="site-modal-header">

					<?php
					if($this->title)
					{
						?>
						<h2 class="site-modal-title">
							<?=$this->title;?>
						</h2>
						<?php
					}
					?>

					<?php
					if($this->headerContent)
					{
						echo $this->headerContent;
					}
					?>
				</div>
				<?php
			}
			?>


			<?php
			if($this->bodyContent)
			{
				?>
				<div class="site-modal-body"><?=$this->bodyContent;?></div>
				<?php
			}
			?>


			<?php
			if($this->footerContent)
			{
				?>
				<div class="site-modal-footer"><?=$this->footerContent;?></div>
				<?php
			}
			?>

		</div>
		<?php
		return ob_get_clean();
	}
}