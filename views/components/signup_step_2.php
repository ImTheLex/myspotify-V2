<?php if(!$userdatas):?>
<!-- Date -->
<label class="flex-col mb-5"  for="signUpBirth">Choisissez votre date de naissance
    <input class="input h-8 border-ridge px-2" type="date" name="signUpBirth" id="signUpBirth" onchange="validateDateNaissance(event)" required>
    <p style="color: red;" id="signupDateNaissanceError" class="hidden">La date est difficilement possible.</p>
</label>

<!-- gender -->
<label class="flex-col mb-5"  for="signUpGender">Choisissez votre genre
    <select class="input h-8 border-ridge px-2" name="signUpGender" id="signUpGender" required>
        <option class="text-black px-2" value="Male">M</option>
        <option class="text-black px-2" value="Female">F</option>
        <option class="text-black px-2" value="No-Binary">Non-binaire</option>
        <option class="text-black px-2" value="Other">Autre</option>
        <option class="text-black px-2" value="No-Comment">Ne se prononce pas</option>
    </select>
</label>
<!-- Artist -->
<p>Créer un compte artiste ?</p>
<div class="flex align-items-c gap-y-2 mb-5">
    <label class="br-cus-2 br-a-1-s rounded-100 h-4 w-4 block"  for="signUpArtistYes">
        <input  class="hidden" type="radio" name="signUpArtist" id="signUpArtistYes" value="oui" >
    </label>
    <p>Oui</p>
    <label class="br-cus-2 br-a-1-s rounded-100 h-4 w-4 block ml-auto bg-white"  for="signUpArtistNo">
        <input class="hidden" type="radio" name="signUpArtist" id="signUpArtistNo" value="non" checked>
    </label>
    <p>Non</p>
</div>

<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>