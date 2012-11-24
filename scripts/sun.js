function ut(h, m, z)
{
    return h-z+m/60;
}

function jd(y,m,d,u)
{
    return (367*y)-Math.floor((7/4)*(Math.floor((m+9)/12)+y))+Math.floor(275*m/9)+d-730531.5+(u/24);
}

function frm(n)
{
    return Math.round(n*1000)/1000;
}

function azimuth(lg, la, ye, mo, da, ho, mi, zo)
{
    with (Math) {
        var uu=ut(ho,mi,zo);
        var jj=jd(ye,mo,da,uu);
        var T=jj/36525;
        var k=PI/180.0;
        var M=357.5291+35999.0503*T-0.0001559*T*T-0.00000045*T*T*T;
        M=M % 360;
        var Lo=280.46645+36000.76983*T+0.0003032*T*T;
        Lo=Lo % 360;
        var DL=(1.9146-0.004817*T-0.000014*T*T)*sin(k*M)+(0.019993-0.000101*T)*sin(k*2*M)+0.00029*sin(k*3*M);
        var L=Lo+DL;
        var eps=23.43999-0.013*T;
        var delta=(1/k)*asin(sin(L*k)*sin(eps*k));
        var RA=(1/k)*atan2(cos(eps*k)*sin(L*k),cos(L*k));
        RA=(RA+360) % 360;
        var GMST=280.46061837+360.98564736629*jj+0.000387933*T*T-T*T*T/38710000;
        GMST=(GMST+360) % 360;
        var LMST=GMST+lg;
        var H=LMST-RA;
        var eqt=(Lo-RA)*4;
        var azm=(1/k)*atan2(-sin(H*k),cos(la*k)*tan(delta*k)-sin(la*k)*cos(H*k));
        azm=(azm+360) % 360;

        return azm;
    }
}

function altitude(lg, la, ye, mo, da, ho, mi, zo)
{
    with (Math) {
        var uu=ut(ho,mi,zo);
        var jj=jd(ye,mo,da,uu);
        var T=jj/36525;
        var k=PI/180.0;
        var M=357.5291+35999.0503*T-0.0001559*T*T-0.00000045*T*T*T;
        M=M % 360;
        var Lo=280.46645+36000.76983*T+0.0003032*T*T;
        Lo=Lo % 360;
        var DL=(1.9146-0.004817*T-0.000014*T*T)*sin(k*M)+(0.019993-0.000101*T)*sin(k*2*M)+0.00029*sin(k*3*M);
        L=Lo+DL;
        var eps=23.43999-0.013*T;
        var delta=(1/k)*asin(sin(L*k)*sin(eps*k));
        var RA=(1/k)*atan2(cos(eps*k)*sin(L*k),cos(L*k));
        RA=(RA+360) % 360;
        var GMST=280.46061837+360.98564736629*jj+0.000387933*T*T-T*T*T/38710000;
        GMST=(GMST+360) % 360;
        var LMST=GMST+lg;
        var H=LMST-RA;
        var eqt=(Lo-RA)*4;
        var alt=(1/k)*asin(sin(la*k)*sin(delta*k)+cos(la*k)*cos(delta*k)*cos(H*k));
        return alt;
    }
}

function calculateSun(la, lg, ye, mo, da, zo)
{
    var ho=0;
    var mi=0;
    var twr=-6.0;
    var tws=-6.0;
    var ewv="East";
    var nsv="North";

    var k=Math.PI/180.0;
    lgo=lg;
    lao=la;
    aa=la>=0 ? 180.0:0.0;

    var alt=altitude(lg,la,ye,mo,da,ho,mi,zo);
    var azm=azimuth(lg,la,ye,mo,da,ho,mi,zo);

    h1=0;
    m=0;
    alt1=altitude(lg,la,ye,mo,da,h1,m,zo);
    azm1=azimuth(lg,la,ye,mo,da,h1,m,zo);
    s=-0.8333;

    // find midday interval
    for (var h=0; h<24; h++){
        h2=h;
        azm2=azimuth(lg,la,ye,mo,da,h2,m,zo);
        if ((azm1<=180)&&(azm2>=180)){
            ha1=h1;
            ha2=h2;
        }
        h1=h2;
        azm1=azm2;
    }
    // find exact midday time
    mino=1.0;
    for (h=ha1; h<ha2; h++) {
        for (m=0; m<60; m++) {
            azmo=azimuth(lg,la,ye,mo,da,h,m,zo);
            dfo=Math.abs(aa-azmo);
            if (dfo<=mino) {
                mino=dfo;
                hno=h;
                mno=m;
            }
        }
    }

    mday="";
    altnoon = altitude(lg,la,ye,mo,da,hno,mno,zo);
    if (altnoon<s)
        mday="nigth";
    hr = mr = hs = ms = null;
    htwr = mtwr = htws = mtws = null;
    mintwr = 0.1;
    minr = 0.1;

    for (h=0; h<=hno; h++) {
        for (m=0; m<60; m++) {
            if (60*h+m< 60*hno+mno) {
                altr=altitude(lg,la,ye,mo,da,h,m,zo);

                dftwr=Math.abs(twr-altr);
                if (dftwr<=mintwr) {
                    mintwr=dftwr;
                    htwr=h;
                    mtwr=m;
                }

                if (altnoon > s) {
                    dfr=Math.abs(s-altr);
                    if (dfr<=minr) {
                        minr=dfr;
                        hr=h;
                        mr=m;
                    }
                }
            }
        }
    }

    mins=0.1;
    mintws=0.1;

    for (h=hno; h<24; h++) {
        for (m=0; m<60; m++) {
            if (60*h+m >= 60*hno+mno) {
                alts=altitude(lg,la,ye,mo,da,h,m,zo);

                if(altnoon>s) {
                    dfs=Math.abs(s-alts);
                    if (dfs<=mins) {
                        mins=dfs;
                        hs=h;
                        ms=m;
                    }
                }

                dftws=Math.abs(tws-alts)
                if (dftws<=mintws) {
                    mintws=dftws;
                    htws=h;
                    mtws=m;
                }
            }
        }
    }

    return {
        morningTwilight: htwr!=null ? { hour: htwr, minute: mtwr } : null,
        sunrise: hr!=null ? { hour: hr, minute: mr } : null,
        midday: { hour: hno, minute: mno },
        sunset: hs!=null ? { hour: hs, minute: ms } : null,
        eveningTwilight: htws!=null ? { hour: htws, minute: mtws } : null,
        altitude: alt,
        azimuth: azm
    };
}
