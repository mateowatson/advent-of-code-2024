<?php

$disk_map = file_get_contents(__DIR__.'/input.txt');

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

$ids_added = [];
for($i = count($block_map) - 1; $i >= 0; $i--) {
    var_dump($i);
    $curr_id = $block_map[$i];
    if($curr_id === '.' || in_array($curr_id, $ids_added)) continue;
    // print_r('BLOCK MAP BEFOR: '.implode(' | ',$block_map)."\n\n");
    $files_to_move_idxes = [$i];
    $ids_added[] = $curr_id;
    $curr_i = $i;
    while($curr_i !== null) {
        $curr_i = $curr_i-1;
        if($block_map[$curr_i] === $curr_id) {
            $files_to_move_idxes[] = $curr_i;
        } else {
            $curr_i = null;
        }
    }
    if(empty($files_to_move_idxes)) continue;
    // print_r('FILES TO MOVE: '.implode(' | ',$files_to_move_idxes)."\n\n");
    // find free space at left most position
    $curr_i = 0;
    $free_space_idxes = [];
    $reset = false;
    while($curr_i !== null) {
        if(count($free_space_idxes) === count($files_to_move_idxes)) {
            $curr_i = null;
            continue;
        }
        if(!isset($block_map[$curr_i])) {
            $curr_i = null;
            continue;
        }
        if($curr_i > $i) {
            $curr_i = null;
            continue;
        }
        // var_dump('while '.$i.' : '.$curr_i);
        if($block_map[$curr_i] === '.') {
            if($reset) {
                $free_space_idxes = [];
            }
            $free_space_idxes[] = $curr_i;
            $reset = false;
        } else {
            $reset = true;
        }
        $curr_i = $curr_i+1;
    }
    if(count($free_space_idxes) !== count($files_to_move_idxes)) {
        $free_space_idxes = [];
    }
    // print_r('FREE IDXES: '.implode(' | ',$free_space_idxes)."\n\n");
    if(empty($free_space_idxes)) continue;
    foreach($files_to_move_idxes as $arr_idx => $files_to_move_idx) {
        [ $block_map[$files_to_move_idx], $block_map[$free_space_idxes[$arr_idx]] ] = [ $block_map[$free_space_idxes[$arr_idx]], $block_map[$files_to_move_idx] ];
    }
    // print_r('BLOCK MAP AFTER: '.implode(' | ',$block_map)."\n\n");
}

// $block_map_compressed = array_merge($block_map_compressed, $free_space_padding);

$check_sum_nums = [];

foreach($block_map as $idx => $num) {
    if($num === '.') continue;

    $check_sum_nums[] = $idx * $num;
}

$check_sum = array_sum($check_sum_nums);

var_dump($check_sum);
