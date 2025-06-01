<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Бронювання кімнат в готелі</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/daypilot-all.min.js"></script>

    <style>
        #dp {
            width: 100%;
            height: 600px;
            margin: 20px auto;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        header, footer {
            background-color: #f0f0f0;
            padding: 10px 20px;
            text-align: center;
        }
        footer address {
            font-style: normal;
        }
        .scheduler_default_rowheader_inner {
            border-right: 1px solid #ccc;
        }
        .scheduler_default_rowheader.scheduler_default_rowheadercol2 {
            background: #fff;
        }
        .scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner {
            background-color: transparent;
            border-left: 5px solid #1a9d13;
            border-right: 0;
        }
        .status_dirty.scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner {
            border-left: 5px solid #ea3624;
        }
        .status_cleanup.scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner {
            border-left: 5px solid #f9ba25;
        }
    </style>
</head>
<body>

<header>
    <h1>HTML5 Бронювання кімнат в готелі (JavaScript/PHP)</h1>
    <p>AJAX-календар з JavaScript/HTML5/jQuery</p>
</header>

<main>
    <div id="dp"></div>
</main>

<footer>
    <address>(с) Автор: студент ПЗіС-24005м, Щербан Петро-Еммануїл Петрович</address>
</footer>

<script>
    var dp = new DayPilot.Scheduler("dp");

    dp.startDate = new DayPilot.Date("2025-06-01");
    dp.days = dp.startDate.daysInMonth();

    dp.scale = "Day";
    dp.timeHeaders = [
        { groupBy: "Month", format: "MMMM yyyy" },
        { groupBy: "Day", format: "d" }
    ];

    dp.rowHeaderColumns = [
        { title: "Кімната", width: 80 },
        { title: "Місткість", width: 80 },
        { title: "Статус", width: 80 }
    ];

    dp.onBeforeResHeaderRender = function(args) {
        var beds = function(count) {
            return count + " ліжко";
        };
        args.resource.columns[0].html = args.resource.name;
        args.resource.columns[1].html = beds(args.resource.capacity);
        args.resource.columns[2].html = args.resource.status;

        switch (args.resource.status.toLowerCase()) {
            case "брудна":
                args.resource.cssClass = "status_dirty";
                break;
            case "прибирається":
                args.resource.cssClass = "status_cleanup";
                break;
        }
    };

    dp.onTimeRangeSelected = function(args) {
        var modal = new DayPilot.Modal({
            onClosed: function(modalArgs) {
                dp.clearSelection();
                if (modalArgs.result && modalArgs.result.result === "OK") {
                    loadEvents();  
                }
            }
        });
        modal.showUrl("new.php?start=" + args.start.toString() + "&end=" + args.end.toString() + "&resource=" + args.resource);
    };

    dp.onEventClick = function(args) {
        var modal = new DayPilot.Modal({
            onClosed: function(modalArgs) {
                if (modalArgs.result && modalArgs.result.result === "OK") {
                    loadEvents();  
                }
            }
        });
        modal.showUrl("edit.php?id=" + args.e.id());
    };

    function loadResources() {
        $.post("backend_rooms.php", function(data) {
            dp.resources = data;
            dp.init();
            loadEvents();
        });
    }

    function loadEvents() {
        var start = dp.visibleStart().toString();
        var end = dp.visibleEnd().toString();
        $.post("backend_events.php", { start: start, end: end }, function(data) {
            dp.events.list = data;
            dp.update();
        });
    }

    loadResources();
</script>

</body>
</html>
