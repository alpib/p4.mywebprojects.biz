<div id='contentviewpaneleft'>
<table>
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
<table class="highchart" data-graph-container-before="1" data-graph-type="pie" style="display:none" data-graph-datalabels-enabled="1">

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
</div>