function load_contracts(contracts) {

 $("#process-status").text(contracts[0].status);

    $(".tender-stage").removeClass("hidden");
    $(".awards-stage").removeClass("hidden");
    $(".contract-stage").removeClass("hidden");

    $("#stage-amount").text(contracts[0].value.amount);
    $("#stage-status").text(contracts[0].status);

    $("#contract-dateSigned").text(contracts[0].dateSigned);
    $("#contract-value-amount").text(contracts[0].value.amount);



    $("#contract-period-endDate").text(contracts[0].period.endDate);
    $("#contract-period-startDate").text(contracts[0].period.startDate);

    $("#contract-id").text(contracts[0].id);

}
