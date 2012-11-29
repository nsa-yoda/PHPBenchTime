<!DOCTYPE html>
<html>
    <head>
        <title>PHPBenchTime Benchmark Usage Tests</title>
        <style type="text/css">
        *{
            margin:0 auto;
            padding:0;
            background-color:#EFEFEF;
        }
        #wrapper{
            margin-top:20px;
            width:80%;
        }
        section { margin:20px 0px 5px 20px; }
        h2, p { margin-bottom:10px; }
        pre {
            clear:both;
            width: 92%;
            overflow: auto;
            margin: 18px 10px 18px 10px;
            padding: 10px 8px 10px 12px;
            color: #3F3B36;
            border: 1px solid #E9E7E0;
            border-left: 6px solid #F5D995;
            font: lighter 12px/20px Monaco,'MonacoRegular',monospace;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
            background: url("data:image/gif;base64,R0lGODlhAQAoAIAAAP////n38CH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IE1hY2ludG9zaCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpGMjNCRjc2NTZCMUYxMUUxOUNENEUzMjYxM0JCQjhBMSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpGMjNCRjc2NjZCMUYxMUUxOUNENEUzMjYxM0JCQjhBMSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkYyM0JGNzYzNkIxRjExRTE5Q0Q0RTMyNjEzQkJCOEExIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkYyM0JGNzY0NkIxRjExRTE5Q0Q0RTMyNjEzQkJCOEExIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+Af/+/fz7+vn49/b19PPy8fDv7u3s6+rp6Ofm5eTj4uHg397d3Nva2djX1tXU09LR0M/OzczLysnIx8bFxMPCwcC/vr28u7q5uLe2tbSzsrGwr66trKuqqainpqWko6KhoJ+enZybmpmYl5aVlJOSkZCPjo2Mi4qJiIeGhYSDgoGAf359fHt6eXh3dnV0c3JxcG9ubWxramloZ2ZlZGNiYWBfXl1cW1pZWFdWVVRTUlFQT05NTEtKSUhHRkVEQ0JBQD8+PTw7Ojk4NzY1NDMyMTAvLi0sKyopKCcmJSQjIiEgHx4dHBsaGRgXFhUUExIREA8ODQwLCgkIBwYFBAMCAQAAIfkEAAAAAAAsAAAAAAEAKAAAAgeMj5nA7f8KADs=") repeat scroll 0 -12px;
            }
        pre code {
            color: #3F3B36;
            background-color: transparent;
            font-size: 12px;
            line-height: 20px;
            font: 12px Monaco,'MonacoRegular',monospace;
        }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <div id="container">
                <h1 class="heading">PHPBenchTime Benchmark Usage</h1>
            </div>
            <section>
                <h2>Require the file and use the classname</h2>
                    <pre><code># Require PHPBenchTime
require("../src/PHPBenchTime.php");

# Namespace
use PHPBenchTime\Timer;</code></pre>
            </section>
            <section>
                <h2>Basic Usage: Sleep for One Second</h2>
                <pre><code>$Benchmark = new PHPBenchTime\Timer();
$Benchmark->Start();
sleep(1);
$end = $Benchmark->End();

/** RESULT:
 * Array ( 
 *     [Start] => 1354132959.1876
 *     [End] => 1354132960.1877
 *     [Total] => 1.0001 )
 */</code></pre>
            </section>
            <section>
                <h2>Basic Usage: Laps</h2>
                    <pre><code>$Benchmark = new PHPBenchTime\Timer();
$Benchmark->Start();
sleep(1);
$Benchmark->Lap();
sleep(1);
$Benchmark->Lap();
sleep(1);
$Benchmark->Lap();
$end = $Benchmark->End();

/** RESULT:
 * Array (
 *     [0] => 1354133093.9828 
 *     [1] => 1354133094.9829
 *     [2] => 1354133095.983
 *     [3] => 1354133096.983 )
 */</code></pre>
            </section>
            <section>
                <h2>Advanced Usage: Named Laps</h2>
                    <pre><code>$Benchmark = new PHPBenchTime\Timer();
$Benchmark->Start("Start Timer");
sleep(1);
$Benchmark->Lap("Slept for 1 second");
sleep(1);
$Benchmark->Lap("Slept for 1 more second");
sleep(1);
$Benchmark->Lap("Slept for another second");
$end = $Benchmark->End();

/** RESULT:
 * Array (
 *     [Start Timer] => 1354133216.622
 *     [Slept for 1 second] => 1354133217.6221
 *     [Slept for 1 more second] => 1354133218.6222
 *     [Slept for another second] => 1354133219.6223 )
 */</code></pre>
            </section>
        </div>
    </body>
</html>
