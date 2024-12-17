<?php

$disk_map = file_get_contents(__DIR__.'/input.txt');

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

$block_map = [];

foreach($files as $file) {
    for($i = 0; $i < $file->blocks; $i++) {
        $block_map[] = $file->id;
    }
    for($i = 0; $i < $file->free_space; $i++) {
        $block_map[] = '.';
    }
}

$block_map_compressed = [];

$free_space_padding = [];

for($i = 0; $i < count($block_map); $i++) {
    if(!isset($block_map[$i])) continue;

    if($block_map[$i] === '.') {
        if($block_map[count($block_map) - 1] === '.') {
            array_pop($block_map);
            $free_space_padding[] = '.';
        }
        
        $block_map_compressed[] = array_pop($block_map);
        $free_space_padding[] = '.';
        
    } else {
        $block_map_compressed[] = $block_map[$i];
    }
    
}

$block_map_compressed = array_merge($block_map_compressed, $free_space_padding);

$check_sum_nums = [];

foreach($block_map_compressed as $idx => $num) {
    if($num === '.') continue;

    $check_sum_nums[] = $idx * $num;
}

$check_sum = array_sum($check_sum_nums);

var_dump($check_sum);

// 7692901063302 is too high