
function buildTimeline(timeline_stage, stage) {


    html = $("ul#main-timeline").html();


    if(!timeline_stage.hasOwnProperty('milestones')) {
        return;
    }


    var timeline_stage = timeline_stage.milestones.filter(function(x) { return x.title == "PENGUMUMAN_LELANG"; });

    timeline_stage.sort(custom_sort);

      console.log(timeline_stage);

    for (i = 0; i < timeline_stage.length; i++) {


        var dueDate = new Date(timeline_stage[i].dueDate);
        var oneDay = 24 * 60 * 60 * 1000;
        var diffDays;

        if (timeline_stage[i].status == "met") {
            var dateMet = new Date(timeline_stage[i].dateMet);





            diffDays = Math.round(((dateMet.getTime() - dueDate.getTime()) / (oneDay)));

            if (diffDays == "0") {
                timing_code = "on-time";
                timing_title = "On Time";
                timing_icon = "check_circle";
                timing_color = "#a8da71";
            } else if (diffDays < 0) {
                timing_code = "on-time";
                timing_title = "Early";
                timing_icon = "check_circle";
                timing_color = "#a8da71";
            } else if (diffDays > 0) {
                timing_code = "late";
                timing_title = "Late";
                timing_icon = "assignment_late";
                timing_color = "#b13a3a";
            }
        } else {
            diffDays = Math.round(((Math.floor(Date.now()) - dueDate.getTime()) / (oneDay)));
            timing_code = "scheduled";
            timing_title = "Plan";
            timing_icon = "date_range";
            timing_color = "transparent";

        }




        html += '<li class="li ' + timeline_stage[i].status + '">';
        html += '<div class="timestamp">';
        html += '<span>' + timeline_stage[i].title + '</span>';
        html += '</div>';
        html += '<div class="status ' + timing_code + ' tooltip-wrapper">';
        html += '<div class="tooltip">';
        html += '<div class="mdc-typography--body2">' + moment(dateMet).format('ll') + '</div>';
        html += '<div>';
        html += '<button class="timeline-status mdc-button mdc-button--compact mdc-button--unelevated" style="background-color:' + timing_color + '">';
        html += ' <i class="material-icons mdc-button__icon">' + timing_icon + '</i>';
        html += timing_title;
        html += '</button> ';
        if (diffDays != 0) {
            html += ' <button class="mdc-button mdc-button--stroked mdc-button--compact" > ' + diffDays + ' days </button>';

        }
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += ' </li>';
    }

    $("ul#main-timeline").html(html);

}
