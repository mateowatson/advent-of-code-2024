<?php

$num_loop_causing_obstacles = 0;

$file_contents = file_get_contents(__DIR__.'/input.txt');
$room = explode("\n", $file_contents);
$starting_pos = null;
$guard_pos = null;
$guard_path = null;
$x_dir = null;
$y_dir = null;
$stop = false;

foreach($room as $idx => $col) {
    $room[$idx] = str_split($col);
    if($guard_x_pos = array_search('^', $room[$idx]))
        $starting_pos = [$guard_x_pos, $idx];
}

// $guard_path[] = json_encode($guard_pos);

foreach($room as $r_idx => $row) {
    foreach($row as $c_idx => $col) {
        if($col !== '.') continue;

        $room[$r_idx][$c_idx] = '#';
        $guard_pos = $starting_pos;
        $guard_path = [];
        $x_dir = 0;
        $y_dir = -1;
        $stop = false;
        $guard_path[] = json_encode($guard_pos);
        $sanity = 0;
        // var_dump('a', $r_idx);

        while($stop === false) {
            var_dump('----', implode(',',[$c_idx,$r_idx]));

            $guard_pos = get_new_guard_pos();

            $last_two_pos = null;

            $guard_path_minus_last_two = null;

            $is_looping = false;

            // $guard_pos_while = true;

            // while($guard_pos_while) {
            //     $new_guard_pos = [$guard_pos[0]+$x_dir, $guard_pos[1]+$y_dir];

            //     $next_space_val = get_space_val($new_guard_pos[0], $new_guard_pos[1]);
            //     // var_dump($next_space_val);

            //     if($next_space_val === '#') {
            //         if($y_dir === -1) {
            //             $y_dir = 0;
            //             $x_dir = 1;
            //         } else if($y_dir === 1) {
            //             $y_dir = 0;
            //             $x_dir = -1;
            //         } else if($x_dir === -1) {
            //             $y_dir = -1;
            //             $x_dir = 0;
            //         } else if($x_dir === 1) {
            //             $y_dir = 1;
            //             $x_dir = 0;
            //         }

            //         // return get_new_guard_pos();
            //         // return [1,1];
            //     } else if($next_space_val === '.' || $next_space_val === '^') {
            //         // return $new_guard_pos;
            //         $guard_pos = $new_guard_pos;
            //         $guard_pos_while = false;
            //     } else {
            //         // return null;
            //         $guard_pos_while = false;
            //     }
            // }

            if(count($guard_path) > 3) {
                $last_two_pos = array_slice(
                    $guard_path,
                    -2,
                );

                $guard_path_minus_last_two = array_slice(
                    $guard_path,
                    0,
                    (count($guard_path) - 2)
                );
            }

            if(!empty($last_two_pos)) {
                $is_looping = str_contains(trim(json_encode($guard_path_minus_last_two), '[]'), trim(json_encode($last_two_pos), '[]'));
                // var_dump(trim(json_encode($guard_path), '[]'), trim(json_encode($last_two_pos), '[]'));
                // var_dump(str_contains(trim(json_encode($guard_path), '[]'), trim(json_encode($last_two_pos), '[]')));
                // var_dump($s_idx, $r_idx, $is_looping, trim(json_encode($guard_path_minus_last_two), '[]'), trim(json_encode($last_two_pos), '[]'));
            }

            if($guard_pos === null) {
                $stop = true;
            } else if($is_looping) {
                $num_loop_causing_obstacles++;
                $stop = true;
            } else {
                // var_dump('---');
                // var_dump(count(array_unique($guard_path)), count($guard_path));
                // var_dump(trim(json_encode($guard_path_minus_last_two), '[]'), trim(json_encode($last_two_pos), '[]'));
                $guard_path[] = json_encode($guard_pos);
            }
        }

        $room[$r_idx][$c_idx] = '.';
    }
}

var_dump($num_loop_causing_obstacles);

function get_space_val($x, $y) {
    global $room;
    if(isset($room[$y], $room[$y][$x]))
        return $room[$y][$x];
    return null;
}

function get_new_guard_pos() {
    global $guard_pos;
    global $x_dir;
    global $y_dir;

    $new_guard_pos = [$guard_pos[0]+$x_dir, $guard_pos[1]+$y_dir];

    $next_space_val = get_space_val($new_guard_pos[0], $new_guard_pos[1]);
    // var_dump($next_space_val);

    if($next_space_val === '#') {
        if($y_dir === -1) {
            $y_dir = 0;
            $x_dir = 1;
        } else if($y_dir === 1) {
            $y_dir = 0;
            $x_dir = -1;
        } else if($x_dir === -1) {
            $y_dir = -1;
            $x_dir = 0;
        } else if($x_dir === 1) {
            $y_dir = 1;
            $x_dir = 0;
        }

        return get_new_guard_pos();
        // return [1,1];
    } else if($next_space_val === '.' || $next_space_val === '^') {
        return $new_guard_pos;
    } else {
        return null;
    }
}