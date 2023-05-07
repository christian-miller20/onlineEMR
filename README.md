# prodEMR
https://github.com/dinger16/prodEMR

Tree structure as deployed on Apache is preserved in project.tar.gz (Will most likely need to look at individual react app code in order to see how it works as react build makes it difficult to read. Majority of frontend code can be found in {appname}/src/components/{appname}.js)

Run `npm install` and `npm run build` on each react app and copy the build/ directories to Apache server with php files in order to rebuild the following tree structure

<img width="448" alt="Screen Shot 2023-05-07 at 3 52 18 PM" src="https://user-images.githubusercontent.com/72777253/236699818-e5b4d4a1-adc3-4e44-a3b7-59270b03b186.png">


Build DB using build script in scripts/ directory
