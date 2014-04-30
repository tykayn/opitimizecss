<div class="row">
                <div class="span5">
                    <div class="alert alert-info">
                        Cet optimiseur n'est pas compatible avec les média queries pour l'instant
                        <br/>L'optimisation comprend:
                        <ul>
                            <li>La non répétition des sélecteurs, des instructions qui se retrouvent écrasées.</li>
                            <li>rassembler les sélecteurs séparés par des virgules tel que a, b = b, a.</li>
                            <li>et d'autres trucs absolument dingues</li>
                        </ul>
                        
                        
                    </div>
                </div>
                <div class="span5">
                    <form action="" method="POST">
                        <textarea name="lecss" id="lecss" cols="60" rows="10"><?php echo $lecss; ?></textarea>
                        <input class="btn btn-primary" type="submit" value="optimiser"/>
                    </form>
                </div>
                
            </div>
                <?php
                if ($newCss != '') {

                    echo ' <h1> Résultat:</h1> <div class="well" contenteditable=true > ' . $newCss . '</div>';
                }
                ?>