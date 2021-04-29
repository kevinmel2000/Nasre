<script>
$(document).ready(function () {
    'use strict';
    $("#thismonthchart").sparkline([5, 6, 2, 9, 4, 7, 10, 12], {
        type: "bar",
        height: "35",
        barWidth: "4",
        resize: !0,
        barSpacing: "4",
        barColor: "#1e88e5"
    }),

    $("#lastmonthchart").sparkline([5, 6, 2, 9, 4, 7, 10, 12], {
        type: "bar",
        height: "35",
        barWidth: "4",
        resize: !0,
        barSpacing: "4",
        barColor: "#7460ee"
    })
});
</script>

