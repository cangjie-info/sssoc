<div class='gy_data'>
    <h2><span><i>Guang yun</i> data:</span></h2>
    <p> <span class='tone'>Tone: <em><?php echo($tone); ?></em></span>
        <span class="rhyme">Rhyme: <em><?php echo($rhyme_name); ?></em></span>
        <span class="niu">Homophone group (<i>niu </i>紐 or <i>xiao yun</i> 小韻): <em><?php echo($niu); ?></em>
            <a href="../gy_niu/?id=<?php echo($niu_id); ?>">(link)</a></span>
        <span class='fanqie'><i>Fanqie</i> 反切 spelling: <em><?php echo($fanqie_1 . $fanqie_2 . '切'); ?></em></span>
        <span class="page">Page: <em><?php echo($page . "." . $number); ?></em></span>
    </p>
    <p>
        <span class='entry'>Dictionary entry: <em><?php echo($entry); ?></em></span>
    <!---INSERT GY HOMOPHONE GROUP -->
    </p>
    <h2><span>Rhyme table and reconstructed data:</span></h2>
    <p>
        <span class='she'>Rhyme category (<i>she</i> 攝): <em><?php echo($she); ?></em></span>
        <span class='hu'>Open/closed (<i>hu</i> 呼): <em><?php echo($hu); ?></em></span>
        <span class='deng'>Division (<i>deng</i> 等): <em><?php echo($deng); ?></em></span>
        <span class='yj_page'><i>Yun jing</i> 韻鏡 page: <em><?php echo($yj_page); ?> </em><a href="../yj/?page=<?php echo($yj_page) ?>">(link)</a></span>
        <span class='initial'>Initial (<i>sheng mu</i> 聲母): <em><?php echo($initial_name); ?></em></span>
    </p>
    <p>
        <span class='pan_ipa'>Pan Wuyun reconstruction: <em><?php echo($initial_ipa_pan . $final_ipa_pan); ?></em></span>
    </p>
    <img src='<?php echo($repo_path . $img_file) ?>' />
    <hr>
</div>