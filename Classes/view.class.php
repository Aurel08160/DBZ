<?php 

/* DBZ VIEW */

class View {
  
    public function __construct () { }
    
    // menu list of table link
    public static function MenuTable ($db_name, $array_table) {
      $menu = "<div id='Menu'><span>DB : ".$db_name."</span>";
      
      foreach ($array_table as $K => $TABLE) {
          foreach($TABLE as $key => $value){
              $menu .= " <a href='?T=".$value."'>[ ".strtoupper($value)." ]</a>";
          }
      }
      
      $menu .= "</div>";
      
      return $menu;
    }

    // Retourne l'affichage des différents choix de requêtes dans la bdd
    public static function funclist (){
        $content = "
            <nav>
                <ul>
                    <li><a href='?T=".$_GET['T']."&amp;req=List'>Lister champ</a></li>
                </ul>
            </nav>
        ";
        return $content;
    }
    
    // Retourne l'affichage des résultats d'un SELECT dans une base précise
    public static function liste($res){
        $row = null;
        $i=0;
        $j=0;
        $list = "<table>";
        foreach($res as $key => $value){
            $list .= "
                <tr>
            ";
            foreach($value as $key2 => $v2){
                if($i==0){
                    $row[$j]=$key2;
                    $j++;
                }
                $list.= "<td>$v2</td>";
            }
            $list .="<td><a href='?T=".$_GET['T']."&amp;key=".$row[0]."&amp;val=".$value[$row[0]]."&amp;req=Suppr'>Supprimer</a></td>";
            $list .="<td><a href='?T=".$_GET['T']."&amp;key=".$row[0]."&amp;val=".$value[$row[0]]."&amp;req=Modif'>Modifier</a></td>";
            $i++;
            $list.= "</tr>";
        }
        $list.="<thead><tr>";
        foreach($row as $key3 => $v3){
            $list .= "<th>".$v3."</th>";
        }
        $list.="</tr></thead>";
        $list.="</table>";
        return $list;
    }

    // Retourne le formulaire de modification de champ
    public static function Modif_form($res){
        $form = "<form method='POST' action='?req=Modif&amp;T=".$_GET['T']."'>";
        foreach($res as $key => $value){
            foreach($value as $key2 => $v2){
                $form .= "<div class='row'><label>$key2</label><input type='text' name='$key2' placeholder='$key2' value='$v2'></div>";
            }
        }
        $form.="<input type='submit' name='Modif' value='Modifier'>";

        return $form;

    }

    // html final rendering
    public static function HTML ($title, $contener) {
      echo "<html>
      <head>
        <title>".$title."</title>
        <link rel='stylesheet' type='text/css' href='Fichiers/css/style.css' />
      </head>
      <body>
       <!-- <img src='Fichiers/images/logo.jpg' /><br /><hr />
        </hr>-->".$contener."
      </body>
      </html>";
    }
    
}

?>
