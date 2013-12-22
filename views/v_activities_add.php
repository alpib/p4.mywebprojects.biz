<div id="contentview">
<form method='POST' action='/activities/p_add'>
    <br><br>
    <span style="color:darkred;font-weight:bold">*</span>
    <label for='activitytype'>What exercise/activity did you do?</label>

             <select id = "activitytype" required name='activitytype' class='searchfield' type='text'>
               <option value = "Aerobic">Aerobic</option>
               <option value = "Walk">Walk</option>
               <option value = "Run">Run</option>
               <option value = "Jog">Jog</option>
               <option value = "Swim">Swim</option>
               <option value = "Hike">Hike</option>
               <option value = "Crossfit">Crossfit</option>
               <option value = "Weights">Weights</option>
               <option value = "Jumba">Jumba</option>
               <option value = "Other">Other</option>
             </select>

    <br><br>

    <span style="color:darkred;font-weight:bold">*</span>
    <label for='activitytime'>For how long? (in mins)</label>
    <input class='searchfield' type='text' required name='activitytime' id='activitytime' onkeypress="return numbersonly(event)" size='30' placeholder='Numbers only'>
    <br><br>

    <span style="color:darkred;font-weight:bold">*</span>
    <label for='caloriesburned'>Approximate calories burned:</label>
    <input class='searchfield' required name='caloriesburned' id='caloriesburned' onkeypress="return numbersonly(event)" size='30' placeholder='Numbers only' >
    <br><br>

    <span style="color:#fff;font-weight:bold">*</span>
    <label for='Date'>Date:</label>
    <input class='searchfield' type="text" id="datepicker" name='date' size='30'></p>

    <span style="color:#fff;font-weight:bold">*</span>
    <label for='Notes'>Notes:</label>
    <br>
    <textarea class='searchfield' name='notes' id='notes'></textarea>

    <br><br>
    <input type='submit' id='button' value='Add New Activity'>
    <br>
   

</form> 
</div>