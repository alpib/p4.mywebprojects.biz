<div id="contentview">
<form method='POST' action='/activities/p_add'>
    <br><br>
    <label for='activitytype'>What exercise/activity did you do?</label>
    <input class='searchfield' type='text' required name='activitytype' id='autocomplete' size='30' >
    <br><br>

    <label for='activitytime'>For how long? (in mins)</label>
    <input class='searchfield' type='text' required name='activitytime' id='activitytime' size='30' >
    <br><br>

    <label for='caloriesburned'>Approximate calories burned:</label>
    <input class='searchfield' name='caloriesburned' id='caloriesburned' size='30' >
    <br><br>


    <label for='Date'>Date:</label>
    <input class='searchfield' type="text" id="datepicker" name='date' size='30'></p>

    <p>Notes:</p>
    <textarea class='searchfield' name='notes' id='notes'></textarea>

    <br><br>
    <input type='submit' id='button' value='Add New Activity'>

</form> 
</div>