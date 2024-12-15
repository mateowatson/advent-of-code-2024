<?php

$disk_map = file_get_contents(__DIR__.'/sample-input.txt');

// var_dump($disk_map);

$digits = array_map(fn($digit) => intval($digit), str_split($disk_map));

class File {
    public int $id;
    public int $blocks;
    public int $free_space;

    public function __construct(int $id, int $blocks, int $free_space) {
        $this->id = $id;
        $this->blocks = $blocks;
        $this->free_space = $free_space;
    }
}

$files = [];

foreach($digits as $idx => $digit) {

    if($idx % 2 === 0) { // 0 or even
        $id = $idx/2;
        $blocks = $digit;
        $free_space = $digits[$idx + 1] ?? 0;
        $files[] = new File($id, $blocks, $free_space);
    }

    if($idx % 2 !== 0) { // odd
        
    }
}

// var_dump($files);

$block_map = '';

foreach($files as $file) {
    for($i = 0; $i < $file->blocks; $i++) {
        $block_map .= $file->id;
    }
    for($i = 0; $i < $file->free_space; $i++) {
        $block_map .= '.';
    }
}

var_dump($block_map);

