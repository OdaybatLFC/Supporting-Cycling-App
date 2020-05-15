var caloriesSpent;
var distance;

function formValidation() {
    var age = document.forms["calorieForm"]["Age"];
    var height = document.forms["calorieForm"]["Height"];
    var weight = document.forms["calorieForm"]["Weight"];
    var duration = document.forms["calorieForm"]["Duration"];
    var formErrors = "";

    age.style.background = "white";
    height.style.background = "white";
    weight.style.background = "white";
    duration.style.backgroundColor = "white";

    if ((age.value == null) || (age.value === "") || (parseInt(age.value) <= 0)) {
        formErrors += "error";
        age.style.backgroundColor = "#FFCCCB";
    }

    if ((height.value == null) || (height.value === "") || (parseInt(height.value) <= 0)) {
        formErrors += "error";
        height.style.backgroundColor = "#FFCCCB";
    }

    if ((weight.value == null) || (weight.value === "") || (parseInt(weight.value) <= 0)) {
        formErrors += "error";
        weight.style.backgroundColor = "#FFCCCB";
    }

    if ((duration.value == null) || (duration.value === "") || (parseInt(duration.value) <= 0)) {
        formErrors += "error";
        duration.style.backgroundColor = "#FFCCCB";
    }

    return formErrors === "";
}

function calculate() {
    if(formValidation()) {

        var weight = parseInt(document.forms["calorieForm"]["Weight"].value);
        var height = parseInt(document.forms["calorieForm"]["Height"].value);
        var age = parseInt(document.forms["calorieForm"]["Age"].value);
        var mets = parseFloat(document.forms["calorieForm"]["Mets"].value);
        var duration = parseInt(document.forms["calorieForm"]["Duration"].value);
        var bmr = 0;

        if (document.forms["calorieForm"]["Gender"].value === "Male") {
            // calculation for men found at https://www.diabetes.co.uk/bmr-calculator.html
            bmr = 66.47 + (13.75 * weight) + (5.003 * height) - (6.755 * age);
            console.log("men");
        } else if (document.forms["calorieForm"]["Gender"].value === "Female") {
            // calculation for women found at https://www.diabetes.co.uk/bmr-calculator.html
            console.log("women");
            bmr = ((655.1 + (9.563 * weight) + (1.85 * height)) - (4.676 * age));
        }

        caloriesSpent = ((bmr * mets) / 24) * duration / 60;
        distance = metsToMph(mets) * duration / 60; // distance -> speed (km) * time (hours)

        if (caloriesSpent < 0) {
            caloriesSpent = 0;
        }

        document.getElementById('caloriesSpent').value = caloriesSpent.toFixed(2);
        document.getElementById('distance').value = distance.toFixed(2);
        document.getElementById('bmr').value = bmr.toFixed(2);
    }
}

function metsToMph(mets) {
    var mph = 0.0;

    if (mets === 3.5) {
        mph = 5.5;
    } else if(mets === 5.8) {
        mph = 9.4;
    } else if(mets === 6.8) {
        mph = 11;
    } else if(mets === 8) {
        mph = 13;
    } else if(mets === 10) {
        mph = 15;
    } else if(mets === 12) {
        mph =  17;
    } else if(mets === 15.8) {
        mph = 21;
    }

    return mph * 1.609;
}