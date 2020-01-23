<?php

// This curriculum assumes the existence of mono which can be found here: https://www.mono-project.com/download/stable/#download-lin-centos

error_reporting(E_ALL);

$csflags = "-v -warnaserror";

function get_csharp_namespace($filename) {
    $namespaceRegex = "/namespace (.*)/";
    if (preg_match($namespaceRegex, file_get_contents($filename), $matches))
        return $matches[1];
}

function get_csharp_class_name($filename) {
    $classregex = '/class (.*)/';
    if (preg_match($classregex, file_get_contents($filename), $matches))
        return $matches[1];
}

function get_type($filename) {
    // Use get_namespace and get_class_name to generate the type
    // for use by the Runner csharp object.
    $type_name = "";
    $namespace = get_csharp_namespace($filename);
    $class_name = get_csharp_class_name($filename);
    if ($namespace != null) {
        $type_name = $type_name.$namespace.".";
    }
    $type_name = $type_name.$class_name;
    return $type_name;
}

function compile($cmd) {
    echo $cmd."\n";
    execute(20, "$cmd", "", $stdout, $stderr);
    if ($stderr == "")
        $output = $stdout;
    else if ($stdout == "")
        $output = $stderr;
    else
        $output = "stderr: \n $stderr\nstdout: $stdout";

    if ($output == "")
        return true;

    echo "$output\n";
    return false;
}

function compile_test($files,$code='') {
    global $csflags;
    if (!empty($code)) {
        file_put_contents("test.cpp", $code);
        $files .= " test.cpp";
    }

    if (compile("mcs $csflags $files"))
        return true;

    if (!empty($code)) // TODO: Figure out what this line is for
        echo "I don't know what this line is for";

    return false;
}

function execution_test($file,&$output, $input='') {
    global $csflags;

    if (!compile("mcs $csflags -main:Runner Runner.cs $file -out:test_program.exe"))
        return false;

    $type_name = get_type($file);
    $output = "";
    execute(20,"mono test_program.exe $type_name",$input,$output,$stderr);

    //TODO -- need a way to show what didn't work (especially when it seg faults)

    if (!empty($stderr)) {
        show_file("errors",$stderr);
        return false;
    }

    return true;
}

function output_contains_lines(string $output,string $needle) {
    if (empty($needle)) return "true";
    // allow heredocs and so forth to be authored on any platform
    $needle = trim(str_replace("\r","\n",str_replace("\r\n","\n",$needle)));
    // allow heredocs and so forth to be authored on any platform
    $output = trim(str_replace("\r","\n",str_replace("\r\n","\n",$output)));
    if (strpos($output,$needle) === false) {
        show_output("expected output",$needle);
        show_output("actual output",$output);
        return false;
    }
    return true;
}

require_once 'unit_tests.php'

?>