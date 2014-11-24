<?php
/**
 * Created by Armand Mahieu.
 * Published for RiPSiLS
 * Date: 04-11-2014
 */



if(isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
}


?>
<p>
    <h1>Daag iemand uit</h1>


    <form method="post" action="Challenges/createscript.php">


        <!-- Naam van tegenstander -->
        <label for="tegenstander">Type the name of your opponent</label>

        <input id="tegenstander" name="Tegenstander" placeholder="Tegenspeler" required="" type="text">
</p>
<p>
        <!-- Uiterst aantal dagen van actieve uitnodiging --
        <label for="verloopdatum">Amount of days that the challenge stays available</label>

        <input id="verloopdatum" name="Verloopdagen" placeholder="3"  max="7" type="number">
        -->
</p>
        <p>
        <!-- Zet kiezen -->
        <label for="lbzet">Choose your challenge<br></label>



        <label class="button">
            <input id="zet" type="radio" name="Zet" value="rock" />
            <img class="selectable" src="img/rock.png">
        </label>
        <label class="button">
            <input id="zet" type="radio" name="Zet" value="paper" />
            <img class="selectable" src="img/paper.png">
        </label>
        <label class="button">
            <input id="zet" type="radio" name="Zet" value="scissors" />
            <img class="selectable" src="img/scissors.png">
        </label>
        <label class="button">
            <input id="zet" type="radio" name="Zet" value="lizard" />
            <img class="selectable" src="img/lizard.png" >
        </label>
        <label class="button">
            <input id="zet" type="radio" name="Zet" value="spock" />
            <img class="selectable" src="img/spock.png">
        </label>

        <input type="submit" value="Challenge!"/>


    </form>
