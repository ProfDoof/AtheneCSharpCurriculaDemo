<?php

include 'csharp_scoring.php';

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

// $files = ["Solutions/ProgramNoNamespace.cs"];
// echo "Compile Test: ".compilation_test()."\n";
// echo "Check Execution (1 and 2): ".check_1_and_2()."\n";
// echo "Check Execution (2 and 3): ".check_2_and_3()."\n";
// echo "Check Execution (10 and 13): ".check_10_and_13()."\n";
// echo "Check Execution (126 and 847): ".check_126_and_847()."\n";
// echo "\n";
// $files = ["Solutions/Program.cs"];
// echo "Compile Test: ".compilation_test()."\n";
// echo "Check Execution (1 and 2): ".check_1_and_2()."\n";
// echo "Check Execution (2 and 3): ".check_2_and_3()."\n";
// echo "Check Execution (10 and 13): ".check_10_and_13()."\n";
// echo "Check Execution (126 and 847): ".check_126_and_847()."\n";
// echo "\n";

// echo "Output Test (Add Two Integers): ".output_contains_lines($testOutput,<<<END
// This program adds two numbers.
// 1st number? <span class=input>1</span>
// 2nd number? <span class=input>2</span>
// The total is 3.
// END
// );
// echo "\n";
?>