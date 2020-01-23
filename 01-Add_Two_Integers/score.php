<?php

/** @test
 *  @score 0.1
 */
function compilation_test() {
    global $csflags;
    global $files;
    return compile("mcs $csflags -main:Runner Runner.cs $files[0] -out:test_program.exe");
}

/** @test
 *  @prereq compilation_test
 *  @score .15
 */
function check_1_and_2() {
    return check_x_and_y("1","2");
}

/** @test
 *  @prereq compilation_test
 *  @score .15
 */
function check_2_and_3() {
    return check_x_and_y("1","2");
}

/** @test
 *  @prereq compilation_test
 *  @score .15
 */
function check_10_and_13() {
    return check_x_and_y("1","2");
}

/** @test
 *  @prereq compilation_test
 *  @score .15
 */
function check_126_and_847() {
    return check_x_and_y("1","2");
}

/** @test
 *  @prereq compilation_test
 *  @score .15
 */
function check_neg5_and_8() {
    return check_x_and_y("-5","8");
}

/** @test
 *  @prereq compilation_test
 *  @score .15
 */
function check_neg5_and_neg8() {
    return check_x_and_y("-5","-8");
}

function check_x_and_y($x, $y) {
    global $files;
    $total = strval(intval($x)+intval($y));
    return execution_test($files[0], $testOutput, "$x\n$y\n") && 
           output_contains_lines($testOutput, <<<END
This program adds two numbers.
1st number? <span class=input>$x</span>
2nd number? <span class=input>$y</span>
The total is $total.
END
        );
}

include 'csharp_scoring.php';
?>