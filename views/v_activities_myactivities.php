<div id="contentview">

    <?php if($activities == false): ?>
        <h2>You have no activities yet</h2>
        <h3>Add some activties</h3>
        <a href='/activities/add'>Add Activity</a>
    <?php endif; ?>


    <?php if($activities == true): ?>
	<h3>My activities:</h3>
    <div id='contentviewpaneleft'>
        <table id="table_id" class="display">
        <thead>
        <tr>
            <th>Type of Activity</th>
            <th>Time</th>
            <th>Calories</th>
            <th>When</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach($activities as $activity): ?>

        <tr>
            <td><?=$activity['activitytype']?></td>
            <td><?=$activity['activitytime']?>mins.</td> <br>
            <td><?=$activity['caloriesburned']?></td>
            <td><?=$activity['date']?></td>
        </tr>

        <?php endforeach; ?>
        </tbody>

        </table>
    </div>

    <div id='contentviewpaneright'>
    </div>
    <table class="highchart" data-graph-container="#contentviewpaneright" data-graph-type="pie" style="display:none" data-graph-datalabels-enabled="1">

    <thead>
        <tr>
            <th>Activity Type</th>
            <th>Time</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach($activities as $activity): ?>

    <tr>
        <td><?=$activity['activitytype']?></td>
        <td data-graph-name='"<?=$activity['activitytype']?>"'><?=$activity['activitytime']?></td>
        
    </tr>

    <?php endforeach; ?>
    </tbody>

    </table>

<?php endif; ?>

</div>