function load_planning(planning) {

    if (planning.hasOwnProperty('budget')) {

        $("#stage-amount").text(release.planning.budget.amount.amount/1000000);
        $("#planning-budget-amount-amount").text(planning.budget.amount.amount);

        $("#planning-rationale").text(planning.rationale);
        $("#planning-budget-description").text(planning.budget.description);


        $("#planning-budget-project-id").text(planning.budget.projectID);
        $("#planning-budget-project-name").text(planning.budget.project);

        $("#planning-budget-id").text(planning.budget.id);

        if (planning.status) {
          $("#stage-status").text(planning.status);
        } else {
            $("#stage-status").hide();
        }
        // var d = new Date(tender.tenderPeriod.startDate);
        //
        // $("#planning-budget-year").text(d.getFullYear());


        // progress
        var month_data = [];
        var mn;

        if (planning.hasOwnProperty('forecasts')) {
            for (i = 0; i < planning.forecasts.length; i++) {

                for (j = 0; j < planning.forecasts[i].observations.length; j++) {
                    mn = planning.forecasts[i].observations[j].period.startDate.substr(5, 2);
                    month_data[mn] = planning.forecasts[i].observations[j].measure;
                    if (planning.forecasts[i].id == "physicalProgress") {
                        $(".planning-physicalProgress[mn='" + mn + "']").text(month_data[mn] + "%");
                        $(".planning-physicalProgress[mn='" + mn + "']").prev().removeClass("hidden");
                        $(".planning-physicalProgress[mn='" + mn + "']").parent().prev().addClass("active");
                    } else if (planning.forecasts[i].id == "financialProgress") {

                        $(".planning-financialProgress[mn='" + mn + "']").text(month_data[mn]);
                        $(".planning-financialProgress[mn='" + mn + "']").prev().removeClass("hidden");

                    }

                }

            }
        }
    }
}
