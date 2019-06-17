#instalar pacote, se necessário
# install.packages("geojsonio",dep = F, repos = "https://cran.fiocruz.br/", lib="/usr/local/lib/R/site-library" )
# install.packages("raster",repos = "http://cran.us.r-project.org", lib="/usr/local/lib/R/site-library" )
args <- commandArgs(TRUE)     
expid <- args[1]  
jsonPath <- args[2]
rasterPath <- args[3]

require(raster)
require(geojsonio)

if(getwd() != "/var/www/html/rafael/modelr"){
	baseUrl <- '../'
} else {
	baseUrl <- ''
}


data_json = geojsonio::geojson_read(jsonPath, what = "sp")
data_json
modelo = raster(rasterPath)
masked = mask(modelo, data_json)
#cat(paste("./temp/BioClim_bin_Abarema langsdorffii (Benth.) Barneby & J.W.Grimes_1_crop-", expid, ".tif", sep=""))
# #salvando o raster .tif
 writeRaster(masked,
                    filename = paste(baseUrl,"./temp/",expid,"/raster_crop-", expid, ".tif", sep=""), overwrite = T)
# #salvando o PNG de visualização
png(filename = paste(baseUrl,"./temp/",expid,"/png_visual-", expid, ".png", sep=""), res = 300,
    width = 410 * 300/72, height = 480 * 300 / 72)
par(mfrow = c(1, 1), mar = c(4, 4, 0, 0))
plot(masked)
maps::map("world", c("", "South America"), add = T, col = "grey")
dev.off()

# #salvado o PNG do raster
 png(filename = paste(baseUrl,"./temp/",expid,"/png_map-", expid, ".png", sep=""), bg = "transparent",
     res = 300, width = 410 * 300/72, height = 480 * 300 / 72)
 par(mar = c(0, 0, 0, 0))
 image(masked, col = rev(terrain.colors(25)), axes = F)
 dev.off()
 
 extent(masked)