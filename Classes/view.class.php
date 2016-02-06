<?php 

/* DBZ VIEW */

class View {
  
    public function __construct () { }
    
    // menu list of table link
    public static function MenuTable ($db_name, $array_table) {
      $menu = "<div>DB : ".$db_name;
      
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
        $list = "<table>";
        foreach($res as $key => $value){
            $list .= "
                <tr>
            ";
            foreach($value as $key2 => $v2){
                $list.= "<td>$v2</td>";
            }
            $list.= "</tr>";
        }
        $list.="</table>";
        return $list;
    }
    
    // html final rendering
    public static function HTML ($title, $contener) {
      echo "<html>
      <head>
        <title>".$title."</title>
        <link rel='stylesheet' type='text/css' href='Fichiers/css/style.css' />
      </head>
      <body>
        <img src='Fichiers/images/logo.jpg' /><br /><hr />
        </hr>".$contener."
      </body>
      </html>";
    }
    
}

?>
