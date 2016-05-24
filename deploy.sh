# Compress files
zip -r wally-theme.zip . -x \*.git\* \*node_modules\* \*bower_components\* gulpfile.js deploy.sh wally-theme.zip .jshintrc package.json \*.DS_Store\*

# Upload to raket.nu ~/vhosts/wally-wp/dist/staging
scp -i ~/.ssh/id_rsa wally-theme.zip raketnu@raket.nu:~/vhosts/wally-wp/dist/staging/wally-theme.zip