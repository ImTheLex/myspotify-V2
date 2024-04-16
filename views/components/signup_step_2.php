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
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>