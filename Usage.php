<!DOCTYPE html>
<html>
<head>
    <title>PHPBenchTime Usage Doc</title>
    <style type="text/css">
        * {
            margin: 0 auto;
            padding: 0;
            background-color: #EFEFEF;
        }

        #wrapper {
            margin-top: 20px;
            width: 80%;
        }

        section {
            margin: 20px 0 5px 20px;
        }

        h2, p {
            margin-bottom: 10px;
        }

        pre {
            clear: both;
            width: 92%;
            overflow: auto;
            margin: 18px 10px 18px 10px;
            padding: 10px 8px 10px 12px;
            color: #3F3B36;
            border: 1px solid #E9E7E0;
            border-left: 6px #F5D995;
            font: lighter 12px/20px Monaco, 'MonacoRegular', monospace;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
            background: url("data:image/gif;base64,R0lGODlhAQAoAIAAAP////n38CH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IE1hY2ludG9zaCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpGMjNCRjc2NTZCMUYxMUUxOUNENEUzMjYxM0JCQjhBMSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpGMjNCRjc2NjZCMUYxMUUxOUNENEUzMjYxM0JCQjhBMSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkYyM0JGNzYzNkIxRjExRTE5Q0Q0RTMyNjEzQkJCOEExIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkYyM0JGNzY0NkIxRjExRTE5Q0Q0RTMyNjEzQkJCOEExIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+Af/+/fz7+vn49/b19PPy8fDv7u3s6+rp6Ofm5eTj4uHg397d3Nva2djX1tXU09LR0M/OzczLysnIx8bFxMPCwcC/vr28u7q5uLe2tbSzsrGwr66trKuqqainpqWko6KhoJ+enZybmpmYl5aVlJOSkZCPjo2Mi4qJiIeGhYSDgoGAf359fHt6eXh3dnV0c3JxcG9ubWxramloZ2ZlZGNiYWBfXl1cW1pZWFdWVVRTUlFQT05NTEtKSUhHRkVEQ0JBQD8+PTw7Ojk4NzY1NDMyMTAvLi0sKyopKCcmJSQjIiEgHx4dHBsaGRgXFhUUExIREA8ODQwLCgkIBwYFBAMCAQAAIfkEAAAAAAAsAAAAAAEAKAAAAgeMj5nA7f8KADs=") repeat scroll 0 -12px;
        }

        pre code {
            color: #3F3B36;
            background-color: transparent;
            line-height: 20px;
            font: 12px Monaco, 'MonacoRegular', monospace;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div id="container">
        <h1 class="heading">PHPBenchTime Usage Documentation</h1>
    </div>
    <section>
        <h2>Require the file and use (or just autoload it)</h2>
<pre><code># Require PHPBenchTime
include("src/Timer.php");

# Namespace
use PHPBenchTime\Timer;</code></pre>
    </section>
    <section>
        <h2>Basic Usage: Sleep for One Second</h2>
<pre><code>$T = new Timer();
sleep(1);
$end = $T->End(); # Returns an array into $end
</code></pre>
    </section>
    <section>
        <h2>Typical Output</h2>
<pre><code>Array (
    [running] => false
    [start] => 1406146951.9998
    [end] => 1406146952.0638
    [total] => 0.063999891281128
    [paused] => 0.041000127792358
    [laps] => Array (
            [0] => Array (
                    [name] => Start
                    [start] => 1406146951.9998
                    [end] => 1406146952.0018
                    [total] => 0.0019998550415039
                )
            [1] => Array (
                    [name] => Second lap
                    [start] => 1406146952.0018
                    [end] => 1406146952.0028
                    [total] => 0.0010001659393311
                )
            [2] => Array (
                    [name] => Third lap
                    [start] => 1406146952.0028
                    [end] => 1406146952.0128
                    [total] => 0.0099999904632568
                )
            [3] => Array (
                    [name] => Tiny lap between pauses
                    [start] => 1406146952.0128
                    [end] => 1406146952.0638
                    [total] => 0.050999879837036
                )
            [4] => Array (
                    [name] => Last lap
                    [start] => 1406146952.0638
                    [end] => 1406146952.0639
                    [total] => 0.0000999999999999
                )
        )
)
</code></pre>
    </section>
    <section>
        <h2>Basic Usage: Laps</h2>
<pre><code>$Benchmark = new Timer();
$T->Start();
sleep(1);
$T->Lap();
sleep(1);
$T->Lap();
sleep(1);
$T->Lap();
$end = $T->End(); # Returns an array into $end
</code></pre>
    </section>
    <section>
        <h2>Advanced Usage: Named Laps</h2>
<pre><code>$T = new Timer();
$T->Start("Start Timer");
sleep(1);
$T->Lap("Slept for 1 second");
sleep(1);
$T->Lap("Slept for 1 more second");
sleep(1);
$T->Lap("Slept for another second");
$end = $T->End(); # Returns an array into $end
</code></pre>
    </section>
    <section>
        <h2>Advanced Usage: Pause and Unpause</h2>
<pre><code>$T = new Timer();
$T->Start("Start Timer");
sleep(1);
$T->Lap("Slept for 1 second");
sleep(1);
$T->Pause();
sleep(3);
$T->Unpause();
$T->Lap("Slept for another second");
$end = $T->End(); # Returns an array into $end
</code></pre>
    </section>
</div>
</body>
</html>
