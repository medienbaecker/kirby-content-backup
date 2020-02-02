<?php
Kirby::plugin('medienbaecker/content-backup', [
	'routes' => [
		[
			'pattern' => 'backup',
			'method' => 'GET|POST',
			'action'  => function() {
				function Zip($source, $destination) {
					if (!extension_loaded('zip') || !file_exists($source)) {
						return false;
					}
					$zip = new ZipArchive();
					if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
						return false;
					}
					$source = str_replace('\\', '/', realpath($source));
					if (is_dir($source) === true) {
						$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
						foreach ($files as $file) {
							$file = str_replace('\\', '/', $file);
							$file = realpath($file);
							if (is_dir($file) === true) {
								$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
							}
							else if (is_file($file) === true) {
								$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
							}
						}
					}
					else if (is_file($source) === true) {
						$zip->addFromString(basename($source), file_get_contents($source));
					}
					return $zip->close();
				}
				$index = kirby()->root('index');
				$content = $index . '/content';
				Zip($content,  $content . '.zip');
				return '<a href="' . site()->url() . '/content.zip">Download content.zip</a>';
			}
		]
  	]
]);