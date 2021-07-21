<?php


function print_warning($str)
{
    return '<div class="alert alert-warning" role="alert">' . $str . '</div>';
}

function print_error($str)
{
    // return '<span style="color: red;">' . $str . '</span>';
    return '<div class="alert alert-danger" role="alert">' . $str . '</div>';
}

function print_success($str)
{
    //return '<span style="color: green;"> ' . $str . '</span>';
    return '<div class="alert alert-success" role="alert">' . $str . '</div>';
}

function checkAndPrint($str, $type)
{
    switch ($type) {
        case 0:
            echo print_error($str);
            break;
        case 1:
            echo print_success($str);
            break;
        case 2:
            echo print_warning($str);
            break;
        default:
            break;
    }
}

function degree_section($degs)
{
    if (empty($degs))
        echo 'Vous n\'avez pas encore ajouté de diplôme !<br>';
    else {
        echo 'Vos diplômes<br><br>';
        $count = 1;
        echo '<table>
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Diplôme</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>';
        foreach ($degs as $deg) {
            echo '<tr>
        <th scope="row">' . $count++ . '</th>';
            echo '<td><embed src=' . __DIR__ . '/degrees/' . $deg['degree'] . ' width=400 height=400 type="application/pdf"/></td>';
            echo '<td><a href="' . __DIR__ . '/deldegree.php?id=' . $deg['id'] . '">Supprimer</a></td>';
            echo '</tr>';
        }
        echo '</tbody>
    </table>';
    }

    echo 'Ajout d\'un diplôme<br>';

    echo '
<form enctype="multipart/form-data" action="newdegree.php" method="post">
    <div class="col mb-3">
        <div class="form-group">
            <label for="degree">Diplôme</label>
            <input type="file" class="form-control-file" name="degree" id="degree" />
            <small id="fileHelp" class="form-text text-muted">Votre fichier doit être au format .pdf.</small>
        </div>
    </div>
    <button type="submit" class="btn btn-primary" name="ajouter">
        Ajouter
    </button>
</form>';
}
