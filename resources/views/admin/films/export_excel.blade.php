<table>
    <thead>
        <tr>
            <th style="background-color: #eeeeee; border: 1px solid #000000; font-weight: bold; text-align: center;">No</th>
            <th style="background-color: #eeeeee; border: 1px solid #000000; font-weight: bold; text-align: center;">Judul Film</th>
            <th style="background-color: #eeeeee; border: 1px solid #000000; font-weight: bold; text-align: center;">Sutradara</th>
            <th style="background-color: #eeeeee; border: 1px solid #000000; font-weight: bold; text-align: center;">Tahun</th>
            <th style="background-color: #eeeeee; border: 1px solid #000000; font-weight: bold; text-align: center;">Genre</th>
            <th style="background-color: #eeeeee; border: 1px solid #000000; font-weight: bold; text-align: center;">Durasi</th>
            <th style="background-color: #eeeeee; border: 1px solid #000000; font-weight: bold; text-align: center;">Pemain</th>
        </tr>
    </thead>
    <tbody>
        @foreach($films as $index => $film)
        <tr>
            <td style="border: 1px solid #000000; text-align: center;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000000;">{{ $film->title }}</td>
            <td style="border: 1px solid #000000;">{{ $film->director }}</td>
            <td style="border: 1px solid #000000; text-align: center;">{{ $film->release_year }}</td>
            <td style="border: 1px solid #000000;">{{ $film->genre }}</td>
            <td style="border: 1px solid #000000;">{{ $film->duration }}</td>
            <td style="border: 1px solid #000000;">{{ $film->cast }}</td>
        </tr>
        @endforeach
    </tbody>
</table>