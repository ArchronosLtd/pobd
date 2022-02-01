rm -R build/

yarn sass --style compressed

zip -r saint-marks-2021.zip *
mkdir build
mv saint-marks-2021.zip build/