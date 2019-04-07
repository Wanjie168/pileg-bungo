function konversi_nilai(value) {
    if(value>=80 && value<=100) $huruf="A"; else
    if(value>=78 && value<80) $huruf="A-"; else
    if(value>=75 && value<78) $huruf="B+"; else
    if(value>=70 && value<75) $huruf="B"; else
    if(value>=68 && value<70) $huruf="B-"; else
    if(value>=65 && value<68) $huruf="C+"; else
    if(value>=60 && value<65) $huruf="C"; else
    if(value>=55 && value<60) $huruf="D+"; else
    if(value>=50 && value<55) $huruf="D"; else
    if(value<50) $huruf="E";
    return $huruf;
}