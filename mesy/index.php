<?php
echo implode(", ", array_map(fn($dir) => $dir, array_filter(glob('*'), 'is_dir')));
