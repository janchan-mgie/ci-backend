echo 'init ...'

php _install/bin/install.php codeigniter

cd _source

# install third party libraries or plug-ins
cat bin/install.txt | while read library;
  do
    php bin/install.php $library;
  done

# clone libraries
for library in ../_install/_clone/*/;
  do
    php bin/clone.php $library;
  done

cd ..

# rm -Rf _install

echo 'done'
