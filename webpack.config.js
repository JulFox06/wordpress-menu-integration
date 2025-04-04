// Utilities.
const path = require('path');
const process = require('node:process');

// WordPress webpack config.
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

// Plugins.
const { glob } = require('glob');
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');

// Function to dynamically get entries
function getEntries() {
  const entries = {};

  // Use glob.sync to search for all .js files in the 'assets/js' folder
  // Ignore the helpers.js file because it's already included in the main.js file
  const jsFiles = glob.sync('assets/js/*.js', {
    ignore: ['assets/js/helpers.js'],
  });

  jsFiles.forEach((file) => {
    const fileName = path.basename(file, path.extname(file));

    entries[`${fileName}`] = path.resolve(process.cwd(), file);
  });

  return entries;
}

module.exports = {
  ...defaultConfig,
  ...{
    entry: {
      // Include WP's default entry.
      ...defaultConfig.entry(),
      ...getEntries(),
    },
    resolve: {
      alias: {
        '@scss': path.resolve(process.cwd(), 'assets/scss/'),
        '@js': path.resolve(process.cwd(), 'assets/js/'),
        '@images': path.resolve(process.cwd(), 'assets/images/'),
      },
    },
    plugins: [
      // Include WP's plugin config.
      ...defaultConfig.plugins,
      new WebpackManifestPlugin({
        publicPath: '', // Prevent "auto" at the beginning of the path
        fileName: 'fonts-manifest.json', // Name of the manifest file
        filter: (file) => file.path.includes('fonts/'), // Filter files to include only fonts
        generate: (seed, files) => {
          return files.reduce((manifest, file) => {
            if (file.path.includes('fonts/')) {
              manifest.push({
                src: file.path,
                file: path.basename(file.path), // Use path.basename to get only the file name
              });
            }

            return manifest;
          }, []);
        },
      }),
      // Removes the empty `.js` files generated by webpack but
      // sets it after WP has generated its `*.asset.php` file.
      new RemoveEmptyScriptsPlugin({
        stage: RemoveEmptyScriptsPlugin.STAGE_AFTER_PROCESS_PLUGINS,
      }),
    ],
  },
};
