@push('scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-rwdImageMaps/1.6/jquery.rwdImageMaps.min.js" integrity="sha512-eZB7hQa0bRlrKMQ2njpP0d/Klu6o30Gsr8e5FUCjUT3fSlnVkm/1J14n58BuwgaMuObrGb7SvUfQuF8qFsPU4g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@vite(['resources/js/imageFileResizing.js'])
@stack('scripts')
@endpush
@extends('layouts.app')
@section('title', 'THE TEAM')
@section('content')
<div class="container">
    <div class="row">
        <h1>About The Team</h1>
        <p>
            Penrith MRT is a registered charity and is a member of the Lake District Search and Mountain Rescue Association LDSAMRA. LDSAMRA, in turn, falls under the governing umbrella of Mountain Rescue England & Wales (MREW).
            <br> Within the LDSAMRA area,there are ten Mountain Rescue Teams as well as two specialist teams (Cumbria Ore Mines Rescue Unit - COMRU and the Lake District Mountain Search Dog Association LDMRSDA).

            <br>Penrith MRT covers the largest geographic area of any of the Lakes District Mountain Rescue Teams. Our area stretches from the Scottish Border in the North to the Northumberland Border in the East, down the North Pennines to High Cup Nick
            above Dufton in the South, with the North-eastern fells of the Lake District (Haweswater) making up our Western boundary. We often work alongside our neighboring Mountain Rescue Teams, particularly Patterdale and Kirkby Stephen.
            <br>The Team is entirely funded by donations and all members are unpaid volunteers, willing to respond any day of the year in any weather.
            <br>The operational members of the Team commit to a rigorous program of training throughout the year, covering casualty care, off-road and ‘blue-light’ driving, radio communications, search management and swiftwater rescue.
            <br>We respond to on average 60+ callouts a year and are on call 365 days per year, 24 hours per day.
        </p>
    </div>
    <div class="row">
        <div class="col-md-8">
            <img width="2500" height="3072" src="{{ asset('area-mapping.png') }}" usemap="#image-map">
            <map name="image-map">
                <area
                    target="_blank"
                    alt="Penrith"
                    title="Penrith"
                    href="https://www.penrithmrt.org.uk/"
                    coords="1537,2065,1407,2034,1327,2052,1289,2026,1239,1979,1309,1727,1287,1694,1305,1624,1261,1575,1208,1588,1157,1564,1044,1571,1038,1465,1011,1436,1013,1403,994,1361,974,1299,943,1297,921,1219,978,1219,1051,1076,1082,921,1036,811,1005,769,1033,749,1013,718,963,725,947,700,888,709,932,634,956,418,1089,447,1309,188,1543,45,1864,338,1864,444,1981,996,2109,1118,2155,1204,2078,1451,2113,1482,1970,1628,1899,1635,1844,1721,1791,1747,1822,1827,1773,1844,1733,1957,1702,2012"
                    shape="poly"
                >
                <area
                    target="_blank"
                    alt="Cockermouth"
                    title="Cockermouth"
                    href="https://www.cockermouthmrt.org.uk/"
                    coords="665,1998,612,2005,608,1976,546,1974,446,1998,199,1899,241,1800,122,1802,69,1738,69,1513,188,1340,307,1106,382,921,572,713,705,669,842,748,930,702,965,725,1023,727,1025,769,1045,804,1080,924,1052,1074,979,1198,930,1206,787,1321,745,1334,694,1423,632,1456,650,1533,641,1646,601,1736,650,1765,606,1818,681,1869,696,1926"
                    shape="poly"
                >
                <area
                    target="_blank"
                    alt="Keswick"
                    title="Keswick"
                    href="https://keswickmrt.org.uk/"
                    coords="661,2002,688,2017,685,2057,749,2061,873,2013,979,1957,995,1929,992,1893,970,1863,986,1805,979,1745,950,1728,1019,1690,1025,1631,1010,1591,1048,1567,1032,1536,1034,1469,1012,1443,988,1368,986,1341,975,1291,939,1288,911,1231,794,1324,754,1337,721,1410,621,1461,661,1518,639,1553,657,1613,643,1662,606,1741,654,1757,617,1807,663,1860,696,1880,696,1918,665,1927"
                    shape="poly"
                >
                <area
                    target="_blank"
                    alt="Patterdale"
                    title="Patterdale"
                    href="https://www.mountainrescue.org.uk/"
                    coords="984,1964,1045,1966,1067,2004,1140,2063,1231,1991,1224,1966,1249,1929,1273,1792,1308,1726,1275,1695,1306,1662,1295,1633,1304,1606,1262,1575,1213,1584,1149,1562,1094,1580,1052,1578,1019,1613,1032,1642,1025,1690,975,1734,992,1757,992,1816,979,1865,1001,1911"
                    shape="poly"
                >
                <area
                    target="_blank"
                    alt="Kendal"
                    title="Kendal"
                    href="http://www.kendalmountainrescue.org.uk/"
                    coords="1216,2009,1242,2000,1278,2033,1333,2048,1415,2040,1554,2066,1518,2104,1545,2168,1613,2214,1653,2212,1655,2238,1772,2274,1814,2360,1852,2375,1856,2336,1885,2362,1847,2458,1792,2467,1971,2522,1980,2557,1871,2584,1774,2712,1679,2820,1540,2915,1076,2942,1081,2577,1054,2529"
                    shape="poly"
                >
                <area
                    target="_blank"
                    alt="Kirkby Stephen"
                    title="Kirkby Stephen"
                    href="https://ksmrt.org.uk/"
                    coords="1968,2527,2070,2513,2123,2467,2397,2065,2370,1873,2150,1705,2183,1533,2105,1486,1940,1632,1876,1652,1849,1718,1801,1734,1840,1822,1765,1855,1739,1957,1715,2010,1553,2063,1531,2098,1573,2182,1644,2226,1776,2273,1823,2354,1840,2319,1878,2341,1856,2443,1805,2471"
                    shape="poly"
                >
            </map>
        </div>
        <div class="col-md-4">
            <div class="row my-2">
                <div class="col-md-6">
                    <a target="_blank" href="https://www.cockermouthmrt.org.uk/">
                        <img class="img-fluid" height=250 width=250 src="{{ asset('cockermouth.jpg')}} " />
                    </a>
                </div>
                <div class="col-md-6">
                    <a target="_blank" href="https://keswickmrt.org.uk/">
                        <img class="img-fluid" height=250 width=250 src="{{ asset('keswick.jpg')}} " />
                    </a>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-md-6">
                    <a target="_blank" href="https://www.mountainrescue.org.uk/">
                        <img class="img-fluid" height=250 width=250 src="{{ asset('patterdale.jpg')}} " />
                    </a>
                </div>
                <div class="col-md-6">
                    <a target="_blank" href="https://ksmrt.org.uk/">
                        <img class="img-fluid" height=250 width=250 src="{{ asset('kirkby-stephen.jpg')}} " />
                    </a>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-md-6">
                    <a target="_blank" href="http://www.kendalmountainrescue.org.uk/">
                        <img class="img-fluid" height=250 width=250 src="{{ asset('kendal.png')}} " />
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2>Penrith Mountain Rescue Team - Promotional Video</h2>
            <p>
                A huge thank you to Bradley Taylor of BT Media for producing this fantastic short film about our Team!

                Bradley kindly offered to produce this short film as part of his Dissertation project for his final year at University. A great way of helping us raise awareness of safety in the outdoors!

                Penrith Mountain Rescue Team is entirely made up of volunteers on call 24/7/365 in all weather conditions. The Team relies entirely on Donations to operate, for more information on how you can help support the Team head over to our <a href="{{ route('donate') }}">DONATE</a> page.
            </p>
        </div>
        <div class="col-md-6">
            <iframe width="802" height="451" src="https://www.youtube.com/embed/maer3PSrIA0" title="Penrith Mountain Rescue Team" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            <p>Penrith Mountain Rescue Team - filmed and produced by
                <a
                    href="https://btmedia1.wixsite.com/home?fbclid=IwAR2luF0zAQqLIOqXOkZqmFdyU8ed7BgtQsbB_rLZ80yOwAwV1FXrKeCNK_E"
                    target="_blank"
                ><strong>Bradley Taylor</strong>
                </a>
            </p>
        </div>
    </div>
@endsection
